<?php
// Incluye la configuración de la base de datos
require_once('conexion.php');
$con = conectar();

$lineasCliente = array();  // Inicializa un array para almacenar las líneas del cliente

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica si la sesión ya está activa antes de iniciarla
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Obtener el user_id de la sesión del usuario
    $user_id = $_SESSION['user_id'];

    // Realiza una consulta SQL para obtener las líneas del cliente
    $sql = "SELECT * FROM lineas WHERE cliente_id = $id AND user_id = $user_id";
    $resultado = mysqli_query($con, $sql);

    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $lineasCliente[] = $fila;  // Agrega cada fila al array
        }
    }
}

// Formatea los datos en un formato JSON válido
$response = array("data" => $lineasCliente);

// Devuelve los datos en formato JSON
echo json_encode($response);
?>



