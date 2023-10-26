<?php
require_once('conexion.php');
$con = conectar();


// Recopila los datos de la solicitud POST
$ventaId = $_POST['id'];
$tipo = $_POST['tipo'];
$cliente = $_POST['cliente'];
$cuenta = $_POST['cuenta'];
$numero_a_renovar = $_POST['numero_a_renovar'];
$persona_encargada = $_POST['persona_encargada'];
$domicilio_entrega = $_POST['domicilio_entrega'];
$id_cliente = $_POST['id_cliente'];
$numero_acuerdo = $_POST['numero_acuerdo'];
$estado = $_POST['estado']; 

// Crea la consulta SQL
$sql = "UPDATE ventas_oportunidades SET tipo = '$tipo', cliente = '$cliente', cuenta = '$cuenta', numero_a_renovar = '$numero_a_renovar', numero_a_renovar = '$numero_a_renovar', persona_encargada = '$persona_encargada', domicilio_entrega = '$domicilio_entrega', id_cliente = '$id_cliente', numero_acuerdo = '$numero_acuerdo', estado = '$estado'  WHERE id = $ventaId";

// Ejecuta la consulta
if (mysqli_query($con, $sql)) {
    // Si la consulta se ejecutó correctamente, devuelve una respuesta JSON de éxito
    echo json_encode(['tipo' => 'success', 'mensaje' => 'Venta actualizada correctamente']);
} else {
    // Si hubo un error al ejecutar la consulta, devuelve una respuesta JSON de error
    echo json_encode(['tipo' => 'error', 'mensaje' => 'Hubo un error al actualizar la Venta: ' . mysqli_error($con)]);
}

// Cierra la conexión a la base de datos
mysqli_close($con);

?>