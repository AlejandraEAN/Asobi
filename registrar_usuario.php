<?php
require 'conexion.php';
header('Content-Type: application/json');

if(isset($_POST['nombre'], $_POST['correo'], $_POST['password'])){
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar si el correo ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    if($stmt->rowCount() > 0){
        echo json_encode(["success" => false, "message" => "El correo ya está registrado"]);
        exit;
    }

    // Insertar usuario
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
    if($stmt->execute([$nombre, $correo, $password])){
        echo json_encode(["success" => true, "message" => "Usuario registrado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar usuario"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
}
?>
