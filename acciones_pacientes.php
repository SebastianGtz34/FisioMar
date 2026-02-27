<?php
/**
 * Archivo: acciones_pacientes.php
 * Usado por: index.php
 *
 * Objetivo:
 * - Recibir datos del formulario de registro de paciente.
 * - Dejar preparado el punto para integrar MySQL más adelante.
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nombreCompleto = trim($_POST['nombreCompleto'] ?? '');
$fechaNacimiento = trim($_POST['fechaNacimiento'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$ocupacion = trim($_POST['ocupacion'] ?? '');
$estadoCivil = trim($_POST['estadoCivil'] ?? '');
$seguroMedico = trim($_POST['seguroMedico'] ?? '');
$archivoOrigen = trim($_POST['archivo_origen'] ?? 'index.php');

if ($nombreCompleto === '' || $fechaNacimiento === '' || $telefono === '' || $correo === '') {
    echo '<h3>Faltan campos obligatorios.</h3>';
    echo '<p><a href="index.php">Volver a index.php</a></p>';
    exit;
}

// PUNTO DE INTEGRACIÓN FUTURA:
// Aquí se agregará la conexión a MySQL (WAMP) y el INSERT real.

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acción de Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card">
        <div class="card-body">
            <h1 class="h4 mb-3">Registro recibido (modo placeholder)</h1>
            <p class="mb-2">El formulario fue enviado correctamente desde <strong><?php echo htmlspecialchars($archivoOrigen, ENT_QUOTES, 'UTF-8'); ?></strong>.</p>
            <p class="text-muted mb-4">Pendiente: guardar en MySQL cuando se integre la base de datos.</p>

            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($nombreCompleto, ENT_QUOTES, 'UTF-8'); ?></li>
                <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($fechaNacimiento, ENT_QUOTES, 'UTF-8'); ?></li>
                <li class="list-group-item"><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono, ENT_QUOTES, 'UTF-8'); ?></li>
                <li class="list-group-item"><strong>Correo:</strong> <?php echo htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'); ?></li>
                <li class="list-group-item"><strong>Ocupación:</strong> <?php echo htmlspecialchars($ocupacion, ENT_QUOTES, 'UTF-8'); ?></li>
                <li class="list-group-item"><strong>Estado Civil:</strong> <?php echo htmlspecialchars($estadoCivil, ENT_QUOTES, 'UTF-8'); ?></li>
                <li class="list-group-item"><strong>Seguro Médico:</strong> <?php echo htmlspecialchars($seguroMedico, ENT_QUOTES, 'UTF-8'); ?></li>
            </ul>

            <a href="index.php" class="btn btn-primary">Volver a Inicio</a>
        </div>
    </div>
</div>
</body>
</html>
