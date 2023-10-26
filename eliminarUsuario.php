<?php
require_once('conexion.php');
$con = conectar();

// Obtén el ID del usuario que se va a eliminar a partir de la solicitud POST
$id = $_POST['id'];

// Crea una consulta SQL para eliminar el registro del usuario
$sql = "DELETE FROM users WHERE id = $id";

// Ejecuta la consulta SQL
if (mysqli_query($con, $sql)) {
    // Si la consulta se ejecutó correctamente, devuelve una respuesta JSON de éxito
    echo json_encode(['tipo' => 'success', 'mensaje' => 'Usuario eliminado correctamente']);
} else {
    // Si hubo un error al ejecutar la consulta, devuelve una respuesta JSON de error
    echo json_encode(['tipo' => 'error', 'mensaje' => 'Hubo un error al eliminar el Usuario: ' . mysqli_error($con)]);
}

// Cierra la conexión a la base de datos
mysqli_close($con);
?>