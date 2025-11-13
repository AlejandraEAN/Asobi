<?php
require 'conexion.php';
header('Content-Type: application/json');

if(isset($_POST['correo'], $_POST['password'])){
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario && password_verify($password, $usuario['password'])){
        echo json_encode(["success" => true, "nombre" => $usuario['nombre']]);
    } else {
        echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
}
?>
