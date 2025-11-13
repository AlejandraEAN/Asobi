<?php
// Datos de conexión al servidor MySQL
$servername = "localhost";
$username = "root";     // Usuario por defecto de XAMPP
$password = "";         // Sin contraseña por defecto
$dbname = "asobi_db";   // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay error en la conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}
?>