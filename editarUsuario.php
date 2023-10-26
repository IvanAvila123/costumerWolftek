<?php
require_once('conexion.php');
$con = conectar();


// Recopila los datos de la solicitud POST
$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$role = $_POST['role'];

// Crea la consulta SQL
$sql = "UPDATE users SET username = '$username', email = '$email', first_name = '$first_name', last_name = '$last_name', role = '$role' WHERE id = $id";

// Ejecuta la consulta
if (mysqli_query($con, $sql)) {
    // Si la consulta se ejecutó correctamente, devuelve una respuesta JSON de éxito
    echo json_encode(['tipo' => 'success', 'mensaje' => 'Usuario actualizado correctamente']);
} else {
    // Si hubo un error al ejecutar la consulta, devuelve una respuesta JSON de error
    echo json_encode(['tipo' => 'error', 'mensaje' => 'Hubo un error al actualizar el Usuario: ' . mysqli_error($con)]);
}

// Cierra la conexión a la base de datos
mysqli_close($con);

?>