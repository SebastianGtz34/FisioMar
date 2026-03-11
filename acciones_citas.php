<?php
include_once 'conn.php';
header('Content-Type: application/json');

$accion = isset($_POST['accion']) ? trim($_POST['accion']) : '';
$usuario = isset($_COOKIE['id_usuario']) ? $_COOKIE['id_usuario'] : '';

$id_cita = isset($_POST['id_cita']) ? intval($_POST['id_cita']) : 0;
$id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
$fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
$hora = isset($_POST['hora']) ? trim($_POST['hora']) : '';
$motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
$estado = isset($_POST['estado']) ? trim($_POST['estado']) : 'Programada';

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
            WHERE c.estado <> 'Realizada'
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

// OBTENER CITAS DEL DÍA
if ($accion == 'obtenerCitasDia') {

    $sql = "SELECT
                c.id_cita,
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

// OBTENER CITAS REALIZADAS
if ($accion == 'obtenerCitasRealizadas') {
    $sql = "SELECT
                c.id_cita,
                c.id_paciente,
                CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                c.fecha,
                c.hora
            FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            WHERE c.estado = 'Realizada'
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
    $sql = "DELETE FROM citas WHERE id_cita=?";
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
            'message' => 'Cita eliminada correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al eliminar cita: ' . $stmt->error
        ]);
    }
    $stmt->close();
    exit;
}

exit;

?>