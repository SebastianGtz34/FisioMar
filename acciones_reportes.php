<?php
include_once 'conn.php';

$accion = isset($_REQUEST['accion']) ? trim($_REQUEST['accion']) : '';
$id_reporte = isset($_REQUEST['id_reporte']) ? intval($_REQUEST['id_reporte']) : 0;
$id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
$tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';

if ($accion !== 'descargarReporte') {
    header('Content-Type: application/json');
}

if (!$conn instanceof mysqli) {
    echo json_encode([
        'success' => false,
        'status' => 'error',
        'message' => 'No se pudo conectar a MySQL. ' . (isset($conn_error) ? $conn_error : '')
    ]);
    exit;
}

// LISTAR REPORTES CON DATOS DE PACIENTE
if ($accion === 'obtenerReportes') {
    $sql = "SELECT
                r.id_reporte,
                r.id_paciente,
                CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                r.tipo,
                r.fecha_generado
            FROM reportes r
            INNER JOIN pacientes p ON p.id_paciente = r.id_paciente
            ORDER BY r.fecha_generado DESC, r.id_reporte DESC";

    $result = $conn->query($sql);
    if (!$result) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al obtener reportes: ' . $conn->error
        ]);
        exit;
    }

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    echo json_encode([
        'success' => true,
        'status' => 'success',
        'data' => $rows
    ]);
    exit;
}

// INSERTAR NUEVO REPORTE
if ($accion === 'guardarReporte') {
    if ($id_paciente <= 0 || $tipo === '') {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Paciente y tipo de reporte son obligatorios.'
        ]);
        exit;
    }

    // Permite valores del formulario actual y valores normalizados de BD.
    $tiposPermitidos = [
        'Historial clínico' => 'Historial Completo',
        'Sesiones realizadas' => 'Sesiones Realizadas',
        'Resumen administrativo' => 'Resumen de Tratamientos',
        'Historial Completo' => 'Historial Completo',
        'Sesiones Realizadas' => 'Sesiones Realizadas',
        'Resumen de Tratamientos' => 'Resumen de Tratamientos'
    ];

    if (!isset($tiposPermitidos[$tipo])) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Tipo de reporte no válido.'
        ]);
        exit;
    }

    $tipoDb = $tiposPermitidos[$tipo];

    $sql = "INSERT INTO reportes (id_paciente, tipo, fecha_generado) VALUES (?, ?, CURRENT_TIMESTAMP)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar inserción: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param('is', $id_paciente, $tipoDb);
    if (!$stmt->execute()) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al guardar reporte: ' . $stmt->error
        ]);
        $stmt->close();
        exit;
    }

    $idNuevo = $conn->insert_id;
    $stmt->close();

    $sqlUltimo = "SELECT
                    r.id_reporte,
                    r.id_paciente,
                    CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                    r.tipo,
                    r.fecha_generado
                FROM reportes r
                INNER JOIN pacientes p ON p.id_paciente = r.id_paciente
                WHERE r.id_reporte = ?
                LIMIT 1";
    $stmtUltimo = $conn->prepare($sqlUltimo);
    if (!$stmtUltimo) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Reporte generado correctamente.',
            'data' => [
                'id_reporte' => $idNuevo,
                'id_paciente' => $id_paciente,
                'tipo' => $tipoDb,
                'fecha_generado' => date('Y-m-d H:i:s')
            ]
        ]);
        exit;
    }

    $stmtUltimo->bind_param('i', $idNuevo);
    $stmtUltimo->execute();
    $resultUltimo = $stmtUltimo->get_result();
    $row = $resultUltimo ? $resultUltimo->fetch_assoc() : null;
    $stmtUltimo->close();

    echo json_encode([
        'success' => true,
        'status' => 'success',
        'message' => 'Reporte generado correctamente.',
        'data' => $row
    ]);
    exit;
}

// ELIMINAR REPORTE
if ($accion === 'eliminarReporte') {
    if ($id_reporte <= 0) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'ID de reporte inválido.'
        ]);
        exit;
    }

    $sql = "DELETE FROM reportes WHERE id_reporte = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar eliminación: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param('i', $id_reporte);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Reporte eliminado correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al eliminar reporte: ' . $stmt->error
        ]);
    }

    $stmt->close();
    exit;
}

// OBTENER DETALLE DE REPORTE
if ($accion === 'obtenerReporteDetalle') {
    if ($id_reporte <= 0) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'ID de reporte inválido.'
        ]);
        exit;
    }

    $sql = "SELECT
                r.id_reporte,
                r.id_paciente,
                CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                p.telefono,
                p.correo,
                r.tipo,
                r.fecha_generado
            FROM reportes r
            INNER JOIN pacientes p ON p.id_paciente = r.id_paciente
            WHERE r.id_reporte = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar consulta de detalle: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param('i', $id_reporte);
    $stmt->execute();
    $result = $stmt->get_result();
    $reporte = $result ? $result->fetch_assoc() : null;
    $stmt->close();

    if (!$reporte) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'No se encontró el reporte solicitado.'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'status' => 'success',
        'data' => $reporte
    ]);
    exit;
}

// DESCARGAR REPORTE EN FORMATO TEXTO
if ($accion === 'descargarReporte') {
    if ($id_reporte <= 0) {
        header('Content-Type: text/plain; charset=utf-8');
        echo "ID de reporte inválido.";
        exit;
    }

    $sql = "SELECT
                r.id_reporte,
                CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                p.telefono,
                p.correo,
                r.tipo,
                r.fecha_generado
            FROM reportes r
            INNER JOIN pacientes p ON p.id_paciente = r.id_paciente
            WHERE r.id_reporte = ?
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        header('Content-Type: text/plain; charset=utf-8');
        echo "Error al preparar descarga: " . $conn->error;
        exit;
    }

    $stmt->bind_param('i', $id_reporte);
    $stmt->execute();
    $result = $stmt->get_result();
    $reporte = $result ? $result->fetch_assoc() : null;
    $stmt->close();

    if (!$reporte) {
        header('Content-Type: text/plain; charset=utf-8');
        echo "No se encontró el reporte solicitado.";
        exit;
    }

    $filename = 'reporte_' . intval($reporte['id_reporte']) . '.txt';
    header('Content-Type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    echo "FISIOMAR - REPORTE\n";
    echo "==================\n\n";
    echo "ID Reporte: " . $reporte['id_reporte'] . "\n";
    echo "Paciente: " . $reporte['paciente'] . "\n";
    echo "Telefono: " . ($reporte['telefono'] ?: 'N/A') . "\n";
    echo "Correo: " . ($reporte['correo'] ?: 'N/A') . "\n";
    echo "Tipo: " . $reporte['tipo'] . "\n";
    echo "Fecha de generacion: " . $reporte['fecha_generado'] . "\n";
    exit;
}

echo json_encode([
    'success' => false,
    'status' => 'error',
    'message' => 'Acción no válida para acciones_reportes.php.'
]);
exit;
