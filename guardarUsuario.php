<?php
require_once('conexion.php');
$con = conectar();
// Recopila los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$role = $_POST['role'];

//Hashea la contraseña

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Crea la consulta SQL
$sql = "INSERT INTO users (username, password, email, first_name, last_name, role) VALUES ('$username', '$hashed_password', '$email', '$first_name', '$last_name', '$role')";

// Ejecuta la consulta
if (mysqli_query($con, $sql)) {
    // Si la consulta se ejecutó correctamente, devuelve una respuesta JSON de éxito
    echo json_encode(['tipo' => 'success', 'mensaje' => 'Usuario ingresado correctamente']);
} else {
    // Si hubo un error al ejecutar la consulta, devuelve una respuesta JSON de error
    echo json_encode(['tipo' => 'error', 'mensaje' => 'Hubo un error al ingresar el Usuario: ' . mysqli_error($con)]);
}

// Cierra la conexión a la base de datos
mysqli_close($con);

?>