<?php
/**
 * Conexión MySQL (WAMP)
 * ---------------------
 * Puedes sobrescribir valores con variables de entorno:
 * DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT
 */

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbName = getenv('DB_NAME') ?: 'fisiomar';
$dbPort = (int) (getenv('DB_PORT') ?: 3306);

$conn = null;
$conn_error = '';

if (class_exists('mysqli')) {
	$conn = @new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

	if ($conn->connect_errno) {
		$conn_error = $conn->connect_error;
		$conn = null;
	} else {
		$conn->set_charset('utf8mb4');
	}
} else {
	$conn_error = 'La extensión mysqli no está disponible en PHP.';
}
