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
$archivoOrigen = isset($_POST['archivo_origen']) ? trim($_POST['archivo_origen']) : 'index.php';

if (!$conn instanceof mysqli) {
    echo json_encode([
        'success' => false,
        'status' => 'error',
        'message' => 'No se pudo conectar a MySQL. ' . (isset($conn_error) ? $conn_error : '')
    ]);
    exit;
}

if ($accion == 'guardarPaciente') {
    if ($nombre === '' || $apellido === '' || $fechaNacimiento === '' || $telefono === '' || $correo === '') {
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
                usuario_registro,
                archivo_origen,
                fecha_registro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

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
        'ssssssssss',
        $nombre,
        $apellido,
        $fechaNacimiento,
        $telefono,
        $correo,
        $ocupacion,
        $estadoCivil,
        $seguroMedico,
        $usuario,
        $archivoOrigen
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

if ($accion == 'obtenerPacientes') {
    $sql = "SELECT
                id_paciente,
                nombre,
                apellido,
                TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad,
                telefono,
                correo,
                fecha_registro
            FROM pacientes
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

echo json_encode([
    'success' => false,
    'status' => 'error',
    'message' => 'Acción no válida para acciones_pacientes.php.'
]);
exit;
