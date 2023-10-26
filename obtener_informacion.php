<?php
// obtener_informacion.php

// Conecta a la base de datos y realiza una consulta para obtener los datos del cliente

// Supongamos que tienes la conexión a la base de datos configurada previamente
require_once('conexion.php');
$con = conectar();

$clienteId = $_GET["cliente_id"];
$userId = $_GET["user_id"];

// Escapa los valores para prevenir SQL injection
$clienteId = mysqli_real_escape_string($con, $clienteId);
$userId = mysqli_real_escape_string($con, $userId);

// Realiza la consulta SQL
$sql = "SELECT fiscal, entrega, rfc FROM informacion WHERE cliente_id = $clienteId AND user_id = $userId";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo "Cliente no encontrado";
}

// Cierra la conexión a la base de datos si es necesario
$con->close();
?>

