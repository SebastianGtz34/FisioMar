<?php
include_once 'conn.php';
header('Content-Type: application/json');

$accion = isset($_POST['accion']) ? trim($_POST['accion']) : '';
$usuario = isset($_COOKIE['id_usuarioL']) ? $_COOKIE['id_usuarioL'] : '';

$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
$fechaNacimiento = isset($_POST['fechaNacimiento']) ? trim($_POST['fechaNacimiento']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$ocupacion = isset($_POST['ocupacion']) ? trim($_POST['ocupacion']) : '';
$estadoCivil = isset($_POST['estadoCivil']) ? trim($_POST['estadoCivil']) : '';
$seguroMedico = isset($_POST['seguroMedico']) ? trim($_POST['seguroMedico']) : '';
$sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : '';
$diagnostico = isset($_POST['diagnostico']) ? trim($_POST['diagnostico']) : '';
$antecedentes = isset($_POST['antecedentes']) ? trim($_POST['antecedentes']) : '';
$folio = isset($_POST['folio']) ? trim($_POST['folio']) : '';
$estatus = isset($_POST['estatus']) ? trim($_POST['estatus']) : '';
$contactoEmergencia = isset($_POST['contactoEmergencia']) ? trim($_POST['contactoEmergencia']) : '';
$telefonoEmergencia = isset($_POST['telefonoEmergencia']) ? trim($_POST['telefonoEmergencia']) : '';
$idPaciente = isset($_POST['id_paciente']) ? (int)$_POST['id_paciente'] : 0;

if (!$conn instanceof mysqli) {
    echo json_encode([
        'success' => false,
        'status' => 'error',
        'message' => 'No se pudo conectar a MySQL. ' . (isset($conn_error) ? $conn_error : '')
    ]);
    exit;
}

// Guardar nuevo paciente
if ($accion == 'guardarPaciente') {
    if ($nombre === '' || $apellido === '' || $fechaNacimiento === '' || $telefono === '' ) {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos obligatorios del paciente.'
        ]);
        exit;
    }

    $sql = "INSERT INTO pacientes (
                nombre,
                apellido,
                fecha_nacimiento,
                telefono,
                correo,
                ocupacion,
                estado_civil,
                seguro_medico,
                fecha_registro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar consulta: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param(
        'ssssssss',
        $nombre,
        $apellido,
        $fechaNacimiento,
        $telefono,
        $correo,
        $ocupacion,
        $estadoCivil,
        $seguroMedico
    );

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Paciente guardado correctamente.',
            'id_paciente' => $conn->insert_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al guardar paciente: ' . $stmt->error
        ]);
    }

    $stmt->close();
    exit;
}

// Obtener lista de pacientes
if ($accion == 'obtenerPacientes') {
    $sql = "SELECT
                id_paciente,
                nombre,
                apellido,
                fecha_nacimiento,
                sexo,
                TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad,
                telefono,
                correo,
                ocupacion,
                estado_civil,
                seguro_medico,
                diagnostico,
                antecedentes,
                folio,
                estatus,
                contacto_emergencia,
                telefono_emergencia,
                fecha_registro
            FROM pacientes
            WHERE estatus = 'Activo'
            ORDER BY id_paciente DESC";

    $result = $conn->query($sql);
    if (!$result) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al obtener pacientes: ' . $conn->error
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

// Modificar paciente
if ($accion == 'modificarPaciente') {
    if ($idPaciente <= 0) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'ID de paciente inválido.'
        ]);
        exit;
    }

    $sql = "UPDATE pacientes SET
                nombre = ?,
                apellido = ?,
                fecha_nacimiento = ?,
                sexo = ?,
                telefono = ?,
                correo = ?,
                ocupacion = ?,
                estado_civil = ?,
                seguro_medico = ?,
                diagnostico = ?,
                antecedentes = ?,
                folio = ?,
                contacto_emergencia = ?,
                telefono_emergencia = ?
            WHERE id_paciente = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar la actualización: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param(
        'sssssssssssssssi',
        $nombre,
        $apellido,
        $fechaNacimiento,
        $sexo,
        $telefono,
        $correo,
        $ocupacion,
        $estadoCivil,
        $seguroMedico,
        $diagnostico,
        $antecedentes,
        $folio,
        $estatus,
        $contactoEmergencia,
        $telefonoEmergencia,
        $idPaciente
    );

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Paciente modificado correctamente.',
            'id_paciente' => $idPaciente
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al modificar paciente: ' . $stmt->error
        ]);
    }

    $stmt->close();
    exit;

}

// Dar de baja paciente
if ($accion == 'darBajaPaciente') {
    if ($idPaciente <= 0) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'ID de paciente inválido.'
        ]);
        exit;
    }

    $sql = "UPDATE pacientes SET estatus = 'Inactivo' WHERE id_paciente = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar la baja del paciente: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param('i', $idPaciente);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Paciente dado de baja correctamente.',
            'id_paciente' => $idPaciente
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al dar de baja al paciente: ' . $stmt->error
        ]);
    }

    $stmt->close();
    exit;
}

echo json_encode([
    'success' => false,
    'status' => 'error',
    'message' => 'Acción no válida para acciones_pacientes.php.'
]);
exit;
