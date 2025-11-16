<?php
header("Content-Type: application/json");
require "conexion.php";

if (!isset($_POST["cancha_id"], $_POST["fecha"], $_POST["hora"], $_POST["usuario"])) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO reservas (cancha_id, fecha, hora, usuario) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST["cancha_id"],
        $_POST["fecha"],
        $_POST["hora"],
        $_POST["usuario"]
    ]);

    echo json_encode(["success" => true, "message" => "Reserva registrada correctamente"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error al guardar la reserva"]);
}
