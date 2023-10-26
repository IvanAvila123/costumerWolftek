<?php
require_once('conexion.php');
$con = conectar();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM ventas_oportunidades WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        echo "Venta eliminada con éxito.";
    } else {
        echo "Error al eliminar la Venta: " . mysqli_error($con);
    }
} else {
    echo "ID de la Venta no proporcionado.";
}
?>