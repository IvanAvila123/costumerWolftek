<?php
require_once('conexion.php');
$con = conectar();

$id = $_POST['id'];

// Realiza la consulta para desactivar al usuario con el ID proporcionado
$sql = "UPDATE users SET baja = 1 WHERE id = $id";
$result = $con->query($sql);

if ($result) {
    echo "Usuario desactivado exitosamente";
} else {
    echo "Error al desactivar el usuario";
}

$con->close();
?>


