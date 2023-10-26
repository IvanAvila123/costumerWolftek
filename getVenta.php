<?php
require_once('conexion.php');
$con = conectar();

session_start();

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Realiza la consulta SQL
    $sql = "SELECT id, tipo, cliente, cuenta, numero_a_renovar, persona_encargada, domicilio_entrega, id_cliente, numero_acuerdo, estado FROM ventas_oportunidades WHERE user_id = $user_id";

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