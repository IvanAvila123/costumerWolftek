<?php
// Incluye la configuración de la base de datos
require_once('conexion.php');
$con = conectar();

// Verifica si la solicitud es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los datos del formulario
    $fiscal = $_POST['fiscal'];
    $entrega = $_POST['entrega'];
    $rfc = $_POST['rfc'];
    $cliente_id = $_POST['cliente_id'];
    $user_id = $_POST['user_id'];

    // Realiza la inserción en la tabla 'informacion'
    $sql = "INSERT INTO informacion (fiscal, entrega, rfc, cliente_id, user_id) 
            VALUES ('$fiscal', '$entrega', '$rfc', $cliente_id, $user_id)";
    
    if (mysqli_query($con, $sql)) {
        echo "Información guardada con éxito.";
    } else {
        echo "Error al guardar la información: " . mysqli_error($con);
    }
} else {
    echo "Acceso no autorizado.";
}
?>


