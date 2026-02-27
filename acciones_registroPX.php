<?php
include_once 'conn.php';
header('Content-Type: application/json');

$accion = isset($_POST['accion']) ? trim($_POST['accion']) : '';
$usuario = isset($_COOKIE['id_usuarioL']) ? $_COOKIE['id_usuarioL'] : '';

$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
$fechaNacimiento = isset($_POST['fechaNacimiento']) ? trim($_POST['fechaNacimiento']) : '';
$sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : '';
$edad = isset($_POST['edad']) ? trim($_POST['edad']) : '';
$estadoCivil = isset($_POST['estadoCivil']) ? trim($_POST['estadoCivil']) : '';
$ocupacion = isset($_POST['ocupacion']) ? trim($_POST['ocupacion']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$seguroMedico = isset($_POST['seguroMedico']) ? trim($_POST['seguroMedico']) : '';
$diagnostico = isset($_POST['diagnostico']) ? trim($_POST['diagnostico']) : '';
$antecedentes = isset($_POST['antecedentes']) ? trim($_POST['antecedentes']) : '';
$folio = isset($_POST['folio']) ? trim($_POST['folio']) : '';
$estatus = isset($_POST['estatus']) ? trim($_POST['estatus']) : '';
$fechaCita = isset($_POST['fechaCita']) ? trim($_POST['fechaCita']) : '';
$horaCita = isset($_POST['horaCita']) ? trim($_POST['horaCita']) : '';
$contactoEmergencia = isset($_POST['contactoEmergencia']) ? trim($_POST['contactoEmergencia']) : '';
$telefonoEmergencia = isset($_POST['telefonoEmergencia']) ? trim($_POST['telefonoEmergencia']) : '';
$archivoOrigen = isset($_POST['archivo_origen']) ? trim($_POST['archivo_origen']) : 'registro_px.php';

if ($accion == 'guardarRegistroPX') {
    if ($nombre === '' || $apellido === '' || $fechaNacimiento === '' || $sexo === '' || $telefono === '' || $correo === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos obligatorios del registro PX.'
        ]);
        exit;
    }

    $sqlRegistraPX = "INSERT INTO pacientes (
                nombre,
                apellido,
                fecha_nacimiento,
                sexo,
                edad,
                estado_civil,
                ocupacion,
                telefono,
                correo,
                seguro_medico,
                diagnostico,
                antecedentes,
                folio,
                estatus,
                fecha_cita,
                hora_cita,
                contacto_emergencia,
                telefono_emergencia,
                usuario_registro,
                archivo_origen,
                fecha_registro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sqlRegistraPX);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar consulta: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param(
        'ssssisssssssssssssss',
        $nombre,
        $apellido,
        $fechaNacimiento,
        $sexo,
        $edad,
        $estadoCivil,
        $ocupacion,
        $telefono,
        $correo,
        $seguroMedico,
        $diagnostico,
        $antecedentes,
        $folio,
        $estatus,
        $fechaCita,
        $horaCita,
        $contactoEmergencia,
        $telefonoEmergencia,
        $usuario,
        $archivoOrigen
    );

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => 'success',
            'message' => 'Registro PX guardado correctamente.',
            'id_paciente' => $conn->insert_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al guardar registro PX: ' . $stmt->error
        ]);
    }

    $stmt->close();
    exit;
}

if ($accion == 'obtenerRegistroPX') {
    $sqlObeterReg = "SELECT
                id_paciente AS id_registro_px,
                nombre,
                apellido,
                fecha_nacimiento,
                sexo,
                telefono,
                correo,
                estatus,
                fecha_registro
            FROM pacientes
            WHERE archivo_origen = 'registro_px.php'
            ORDER BY id_paciente DESC";

    $result = $conn->query($sqlObeterReg);
    if (!$result) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al obtener registros PX: ' . $conn->error
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
    'message' => 'Acción no válida para acciones_registroPX.php.'
]);
exit;
