<?php
require 'conexion.php';
header('Content-Type: application/json');

if(!empty($_POST['correo']) && !empty($_POST['password'])){

    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, nombre, correo, password FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario && password_verify($password, $usuario['password'])){
        echo json_encode([
            "success" => true,
            "message" => "Inicio de sesión exitoso",
            "nombre"  => $usuario['nombre'],
            "correo"  => $usuario['correo']
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Correo o contraseña incorrectos"
        ]);
    }

} else {
    echo json_encode([
        "success" => false,
        "message" => "Todos los campos son obligatorios"
    ]);
}

