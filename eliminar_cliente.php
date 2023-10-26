<?php
require_once('conexion.php');
$con = conectar();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM clientes WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        echo "Cliente eliminado con éxito.";
    } else {
        echo "Error al eliminar el cliente: " . mysqli_error($con);
    }
} else {
    echo "ID de cliente no proporcionado.";
}
?>
