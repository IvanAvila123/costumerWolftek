<?php
require_once('conexion.php');
$con = conectar();

session_start();

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Realiza la consulta SQL
    $sql = "SELECT id, razon, cuenta, id_cliente, telefono_contacto, representante, correo, ejecutivo FROM clientes WHERE user_id = $user_id";

    // Ejecuta la consulta y maneja cualquier error
    $result = $con->query($sql);
    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode(array("data" => $data));
    } else {
        echo json_encode(array("data" => array())); // Devuelve un arreglo vacío en caso de error
    }
} else {
    echo json_encode(array("data" => array())); // Devuelve un arreglo vacío si el usuario no ha iniciado sesión
}
?>


