<?php
header('Content-Type: application/json');
include 'conexion.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Crear un nuevo evento
    $nombre = $_POST['nombre'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $lugar = $_POST['lugar'] ?? '';

    if (!$nombre || !$fecha || !$lugar) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos del evento']);
        exit;
    }

    // Guardar coordenadas opcionales (para el mapa)
    $lat = 4.65; // Puedes cambiar por un valor fijo o dinámico
    $lng = -74.1;

    $query = "INSERT INTO eventos (nombre, fecha, lugar, lat, lng) VALUES ('$nombre', '$fecha', '$lugar', '$lat', '$lng')";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Evento agregado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el evento']);
    }

} elseif ($method === 'GET') {
    // Listar todos los eventos
    $result = mysqli_query($conn, "SELECT * FROM eventos");
    $eventos = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $eventos[] = $row;
    }

    echo json_encode(['success' => true, 'eventos' => $eventos]);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>