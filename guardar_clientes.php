<?php
require('conexion.php');
$con = conectar();

$user_id = $_POST['user_id'];
$razon = $_POST['razon'];
$cuenta = $_POST['cuenta'];
$id_cliente = $_POST['id_cliente'];
$telefono_contacto = $_POST['telefono_contacto'];
$representante = $_POST['representante'];
$correo = $_POST['correo'];
$ejecutivo = $_POST['ejecutivo'];

$sql = "INSERT INTO clientes (razon, cuenta, id_cliente, telefono_contacto, representante, correo, ejecutivo, user_id) VALUES ('$razon', '$cuenta', '$id_cliente', '$telefono_contacto', '$representante', '$correo', '$ejecutivo', '$user_id')";

if (mysqli_query($con, $sql)) {
    echo "Nuevo cliente guardado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);
?>

