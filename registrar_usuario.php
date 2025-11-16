<?php
require "conexion.php";

// Validar que existan las variables esperadas
if (
    empty($_POST["nombre"]) ||
    empty($_POST["correo"]) ||
    empty($_POST["password"])
) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan datos requeridos"
    ]);
    exit;
}

$nombre   = trim($_POST["nombre"]);
$correo   = trim($_POST["correo"]);
$password = password_hash($_POST["password"], PASSWORD_BCRYPT);

// Validar correo duplicado
$sqlCheck = "SELECT id FROM usuarios WHERE correo = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->execute([$correo]);

if ($stmtCheck->rowCount() > 0) {
    echo json_encode([
        "success" => false,
        "message" => "El correo ya está registrado"
    ]);
    exit;
}

// Insertar usuario
$sql = "INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([$nombre, $correo, $password]);

if ($result) {
    echo json_encode([
        "success" => true,
        "message" => "Usuario registrado correctamente 🎉"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al registrar usuario"
    ]);
}

$stmt = null;
$conn = null;
?>
