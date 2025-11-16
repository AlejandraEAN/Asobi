<?php
require "conexion.php";
header('Content-Type: application/json');

try {
    $sql = "SELECT r.id, r.fecha, r.hora, r.usuario, c.nombre AS cancha
            FROM reservas r
            INNER JOIN canchas c ON c.id = r.cancha_id
            ORDER BY r.fecha ASC, r.hora ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "data" => $reservas]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: ".$e->getMessage()]);
}
