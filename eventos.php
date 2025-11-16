<?php
require 'conexion.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Crear evento
    $nombre = $_POST['nombre'] ?? '';
    $fecha  = $_POST['fecha'] ?? '';
    $lugar  = $_POST['lugar'] ?? '';
    $lat    = $_POST['lat'] ?? null;
    $lng    = $_POST['lng'] ?? null;

    if(!$nombre || !$fecha || !$lugar){
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO eventos (nombre, fecha, lugar, lat, lng) VALUES (?, ?, ?, ?, ?)");
    if($stmt->execute([$nombre, $fecha, $lugar, $lat, $lng])){
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al crear evento"]);
    }
} else {
    // Obtener eventos
    $stmt = $pdo->query("SELECT * FROM eventos ORDER BY fecha ASC");
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["success" => true, "eventos" => $eventos]);
}
?>
