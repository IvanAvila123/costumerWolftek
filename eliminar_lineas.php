<?php
require_once('conexion.php');
$con = conectar();

if (isset($_POST['id'])) {
    $linea_id = $_POST['id'];
    $sql = "DELETE FROM lineas WHERE id = $linea_id";
    if (mysqli_query($con, $sql)) {
        echo "Linea eliminado con éxito.";
    } else {
        echo "Error al eliminar la Linea: " . mysqli_error($con);
    }
} else {
    echo "ID de la Linea no proporcionado.";
}
?>