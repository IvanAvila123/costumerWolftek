<?php
require('conexion.php');
$con = conectar();

$linea_id = $_POST['id'];
$dn = $_POST['dn'];
$fecha = $_POST['fecha'];
$plan = $_POST['plan'];
$equipo = $_POST['equipo'];


$stmt = $con->prepare("UPDATE lineas SET dn = ?, fecha = ?, plan = ?, equipo = ? WHERE id = ?");
$stmt->bind_param("ssssi", $dn, $fecha, $plan, $equipo, $linea_id);

if ($stmt->execute()) {
  echo "Registro actualizado con éxito";
} else {
  echo "Error actualizando el registro: " . $stmt->error;
}

$stmt->close();
$con->close();

?>