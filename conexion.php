<?php
// 🔧 OCULTAR ERRORES EN LA RESPUESTA JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log'); // guarda errores en php-error.log

$host = "localhost";
$dbname = "asobi_db";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error conexión DB: " . $e->getMessage()
    ]);
    exit;
}
