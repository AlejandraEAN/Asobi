<?php
require "conexion.php";
header("Content-Type: application/json");

try {
    $stmt = $pdo->query("SELECT id, nombre, lat, lng FROM canchas");
    $canchas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "data" => $canchas]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
