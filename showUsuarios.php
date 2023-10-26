<?php
require_once('conexion.php');
$con = conectar();

$sql = "SELECT id, username, email, first_name, last_name, role, baja FROM users";
$res = $con->query($sql);

$data = array();

while($fila = $res->fetch_assoc()){
    $data[] = $fila;
}

// Devuelve los datos en formato JSON directamente
echo json_encode(array('data' => $data));

$con->close();
?>