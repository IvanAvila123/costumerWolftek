<?php
require_once('conexion.php');
$con = conectar();

session_start();

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $hoy = date('Y-m-d');
    $renovacionAnticipadaT1 = date('Y-m-d', strtotime('+1 month', strtotime($hoy)));

    // Realiza la consulta SQL
    $sql = "SELECT * FROM clientes INNER JOIN lineas ON clientes.id = lineas.cliente_id WHERE lineas.fecha BETWEEN '$hoy' AND DATE_ADD('$hoy', INTERVAL 1 MONTH) AND clientes.user_id = $user_id";

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