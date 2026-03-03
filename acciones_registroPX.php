<?php
include_once 'conn.php';
header('Content-Type: application/json');

$accion = isset($_POST['accion']) ? trim($_POST['accion']) : '';
$usuario = isset($_COOKIE['id_usuario']) ? $_COOKIE['id_usuario'] : '';

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

// REGISTRAR NUEVO PACIENTE
if ($accion == 'guardarRegistroPX') {
    // Validar campos obligatorios
    if ($nombre === '' || $apellido === '' || $fechaNacimiento === '' || $sexo === '' || $telefono === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan campos obligatorios del registro PX.'
        ]);
        exit;
    }

    // Verificar duplicados por nombre, apellido y teléfono
    $sqlDuplicado = "SELECT id_paciente FROM pacientes WHERE nombre = ? AND apellido = ? AND telefono = ?";
    $stmtDup = $conn->prepare($sqlDuplicado);
    if (!$stmtDup) {
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Error al preparar consulta de duplicados: ' . $conn->error
        ]);
        exit;
    }
    $stmtDup->bind_param('sss', $nombre, $apellido, $telefono);
    $stmtDup->execute();
    $stmtDup->store_result();
    if ($stmtDup->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'status' => 'duplicado',
            'message' => 'Ya existe un paciente registrado con estos datos.'
        ]);
        $stmtDup->close();
        exit;
    }
    $stmtDup->close();

    // Insertar nuevo paciente
    $sqlRegistraPX = "INSERT INTO pacientes (
                                nombre, apellido, fecha_nacimiento, sexo, edad,
                                estado_civil, ocupacion, telefono, correo,
                                seguro_medico, diagnostico, antecedentes, folio,
                                estatus, contacto_emergencia, telefono_emergencia, fecha_registro)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    echo $sqlRegistraPX; // Debug: mostrar la consulta SQL antes de prepararla
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
        'ssssisssssssssss',
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
        $contactoEmergencia,
        $telefonoEmergencia
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

// OBTENER REGISTROS DE PACIENTES
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

//

exit;
