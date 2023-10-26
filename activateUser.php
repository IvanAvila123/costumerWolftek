<?php
require_once('conexion.php');
$con = conectar();

$id = $_POST['id'];

// Actualiza el campo 'baja' del usuario a 0 (reactivado)
$sql = "UPDATE users SET baja = 0 WHERE id = $id";

if (mysqli_query($con, $sql)) {
    echo 'Usuario reactivado exitosamente';
} else {
    echo 'Error al reactivar al usuario: ' . mysqli_error($con);
}

mysqli_close($con);
?>
