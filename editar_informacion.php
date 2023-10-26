<?php
require_once('conexion.php');
$con = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clienteId = $_POST["cliente_id"];
    $user_id = $_POST["user_id"];
    $fiscal = $_POST["fiscal"];
    $entrega = $_POST["entrega"];
    $rfc = $_POST["rfc"];

    // Realiza una consulta SQL para actualizar los datos del cliente en la base de datos
    $sql = "UPDATE informacion SET fiscal = '$fiscal', entrega = '$entrega', rfc = '$rfc' WHERE cliente_id = $clienteId AND user_id = $user_id";
    
    if (mysqli_query($con, $sql)) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false));
    }
    
}
?>

