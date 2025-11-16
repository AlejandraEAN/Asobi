<?php
require "conexion.php";
header('Content-Type: application/json');

try {
    $sql = "SELECT id, nombre, fecha, lugar FROM eventos ORDER BY fecha ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "data" => $eventos]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: ".$e->getMessage()]);
}

