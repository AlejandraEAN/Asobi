<?php
header('Content-Type: application/json');
include 'conexion.php';

$cancha_id = intval($_POST['cancha_id'] ?? 0);
$usuario   = $conn->real_escape_string(trim($_POST['usuario'] ?? 'Anonimo'));
$fecha     = $_POST['fecha'] ?? date('Y-m-d');
$hora      = $_POST['hora'] ?? date('H:i');

// Validaciones simples
if (!$cancha_id) {
    echo json_encode(['success'=>false,'message'=>'Cancha inválida']);
    exit;
}

// Insertar reserva
$stmt = $conn->prepare("INSERT INTO reservas (cancha_id, fecha, hora, usuario) VALUES (?,?,?,?)");
$stmt->bind_param("isss", $cancha_id, $fecha, $hora, $usuario);

if ($stmt->execute()) {
    // Actualizar estado de la cancha a 'Ocupado'
    $upd = $conn->prepare("UPDATE canchas SET estado='Ocupado' WHERE id = ?");
    $upd->bind_param("i", $cancha_id);
    $upd->execute();
    $upd->close();

    echo json_encode(['success'=>true,'message'=>'Reserva guardada y cancha marcada como Ocupada']);
} else {
    echo json_encode(['success'=>false,'message'=>'Error al guardar reserva: '.$stmt->error]);
}
$stmt->close();
$conn->close();
?>