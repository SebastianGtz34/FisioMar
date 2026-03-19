<?php
include_once 'conn.php';
header('Content-Type: application/json');

$accion = isset($_POST['accion']) ? trim($_POST['accion']) : '';

$id_cita = isset($_POST['id_cita']) ? intval($_POST['id_cita']) : 0;
$id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
$fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
$hora = isset($_POST['hora']) ? trim($_POST['hora']) : '';
$motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
$estado = isset($_POST['estado']) ? trim($_POST['estado']) : 'Programada';
$diagnostico = isset($_POST['diagnostico']) ? trim($_POST['diagnostico']) : '';
$antecedentes = isset($_POST['antecedentes']) ? trim($_POST['antecedentes']) : '';
$exploracion = isset($_POST['exploracion']) ? trim($_POST['exploracion']) : '';
$tratamiento = isset($_POST['tratamiento']) ? trim($_POST['tratamiento']) : '';

// CREAR NUEVA CITA
if ($accion == 'crearCita') {
    $sql = "INSERT INTO citas (
                id_paciente,
                fecha,
                hora,
                motivo,
                estado
            ) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar consulta: ' . $conn->error
        ]);
        exit;
    }
    $stmt->bind_param('issss', $id_paciente, $fecha, $hora, $motivo, $estado);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Cita registrada correctamente.',
            'id_cita' => $conn->insert_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al registrar cita: ' . $stmt->error
        ]);
    }
    $stmt->close();
    exit;
}

// OBTENER LISTA DE CITAS
if ($accion == 'obtenerCitas') {
    $sql = "SELECT
                c.id_cita,
                c.id_paciente,
                CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                c.fecha,
                c.hora,
                c.motivo,
                c.estado
            FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            WHERE c.estado = 'Programada'
            ORDER BY c.fecha DESC, c.hora DESC";

    $result = $conn->query($sql);

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

// OBTENER LISTA DE CITAS AGRUPADAS POR ESTADO
if ($accion == 'obtenerCitasPorEstado') {
    $sql = "SELECT
                c.id_cita,
                c.id_paciente,
                CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                c.fecha,
                c.hora,
                c.motivo,
                c.estado
            FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            WHERE c.estado IN ('Programada', 'Realizada', 'Reprogramada', 'Cancelada')
            ORDER BY c.fecha DESC, c.hora DESC";

    $result = $conn->query($sql);
    if (!$result) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al obtener citas por estado: ' . $conn->error
        ]);
        exit;
    }

    $agrupadas = [
        'Programada' => [],
        'Realizada' => [],
        'Reprogramada' => [],
        'Cancelada' => []
    ];

    while ($row = $result->fetch_assoc()) {
        if (isset($agrupadas[$row['estado']])) {
            $agrupadas[$row['estado']][] = $row;
        }
    }

    echo json_encode([
        'success' => true,
        'status' => 'success',
        'data' => $agrupadas
    ]);
    exit;
}

// OBTENER CITAS DEL DÍA
if ($accion == 'obtenerCitasDia') {

    $sql = "SELECT
                c.id_cita,
                c.id_paciente,
                CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                c.fecha,
                c.hora,
                c.motivo,
                c.estado
            FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                WHERE c.fecha = CURDATE()
                AND c.estado NOT IN ('Realizada', 'Cancelada')
            ORDER BY ABS(TIMESTAMPDIFF(SECOND, NOW(), TIMESTAMP(c.fecha, c.hora))) ASC";
        $result = $conn->query($sql);
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

// FINALIZAR CITA Y GUARDAR BITACORA CLINICA
if ($accion == 'finalizarCitaConBitacora') {
    if ($id_cita <= 0 || $diagnostico === '' || $exploracion === '' || $tratamiento === '') {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Faltan datos obligatorios para registrar la bitácora clínica.'
        ]);
        exit;
    }

    $sqlCita = "SELECT id_paciente, estado FROM citas WHERE id_cita = ? LIMIT 1";
    $stmtCita = $conn->prepare($sqlCita);
    if (!$stmtCita) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar consulta de cita: ' . $conn->error
        ]);
        exit;
    }

    $stmtCita->bind_param('i', $id_cita);
    $stmtCita->execute();
    $resultCita = $stmtCita->get_result();
    $cita = $resultCita ? $resultCita->fetch_assoc() : null;
    $stmtCita->close();

    if (!$cita) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'La cita no existe.'
        ]);
        exit;
    }

    if ($cita['estado'] === 'Cancelada') {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'No se puede finalizar una cita cancelada.'
        ]);
        exit;
    }

    if ($cita['estado'] === 'Realizada') {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Esta cita ya está marcada como realizada.'
        ]);
        exit;
    }

    $idPacienteCita = (int) $cita['id_paciente'];

    try {
        $conn->begin_transaction();

        $sqlUpdate = "UPDATE citas SET estado = 'Realizada' WHERE id_cita = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        if (!$stmtUpdate) {
            throw new Exception('Error al preparar actualización de cita: ' . $conn->error);
        }
        $stmtUpdate->bind_param('i', $id_cita);
        if (!$stmtUpdate->execute()) {
            throw new Exception('Error al actualizar estado de cita: ' . $stmtUpdate->error);
        }
        $stmtUpdate->close();

        $sqlBitacora = "INSERT INTO datos_clinicos (
                            id_paciente,
                            id_cita,
                            diagnostico,
                            antecedentes,
                            exploracion,
                            tratamiento,
                            fecha_registro
                        ) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
        $stmtBitacora = $conn->prepare($sqlBitacora);
        if (!$stmtBitacora) {
            throw new Exception('Error al preparar inserción de bitácora: ' . $conn->error);
        }

        $stmtBitacora->bind_param(
            'iissss',
            $idPacienteCita,
            $id_cita,
            $diagnostico,
            $antecedentes,
            $exploracion,
            $tratamiento
        );

        if (!$stmtBitacora->execute()) {
            throw new Exception('Error al guardar bitácora clínica: ' . $stmtBitacora->error);
        }
        $stmtBitacora->close();

        $conn->commit();

        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Cita finalizada y bitácora registrada correctamente.'
        ]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }

    exit;
}

// OBTENER TOTAL DE CITAS REALIZADAS
if ($accion == 'obtenerTotalSesionesRealizadas') {
    $sql = "SELECT COUNT(*) AS total FROM citas WHERE estado = 'Realizada'";
    $result = $conn->query($sql);

    $total = 0;
    if ($result && $row = $result->fetch_assoc()) {
        $total = (int) $row['total'];
    }

    echo json_encode([
        'success' => true,
        'status' => 'success',
        'data' => [
            'total' => $total
        ]
    ]);
    exit;
}

// EDITAR CITA
if ($accion == 'editarCita') {
    if ($id_cita <= 0 || $id_paciente <= 0 || $fecha === '' || $hora === '' || $motivo === '' || $estado === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos obligatorios para editar la cita.'
        ]);
        exit;
    }

    $sql = "UPDATE citas SET id_paciente=?, fecha=?, hora=?, motivo=?, estado=? WHERE id_cita=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar consulta: ' . $conn->error
        ]);
        exit;
    }
    $stmt->bind_param('issssi', $id_paciente, $fecha, $hora, $motivo, $estado, $id_cita);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Cita actualizada correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al actualizar cita: ' . $stmt->error
        ]);
    }
    $stmt->close();
    exit;
}

// ELIMINAR CITA
if ($accion == 'eliminarCita') {
    if ($id_cita <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'ID de cita inválido.'
        ]);
        exit;
    }
    $sql = "UPDATE citas SET estado='Cancelada' WHERE id_cita=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar consulta: ' . $conn->error
        ]);
        exit;
    }
    $stmt->bind_param('i', $id_cita);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Cita cancelada correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al cancelar cita: ' . $stmt->error
        ]);
    }
    $stmt->close();
    exit;
}

exit;

?>