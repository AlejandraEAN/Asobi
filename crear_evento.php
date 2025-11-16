<?php
header("Content-Type: application/json");

// Validar datos obligatorios
if (!isset($_POST["nombre"]) || !isset($_POST["fecha"]) || !isset($_POST["lugar"])) {
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
    exit;
}

$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"]; // DATE
$lugar = $_POST["lugar"];

// Conexión BD
require "conexion.php";

// Insertar evento
$stmt = $conn->prepare("INSERT INTO eventos (nombre, fecha, lugar) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $fecha, $lugar);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Evento creado con éxito"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al crear evento"]);
}

$stmt->close();
$conn->close();


