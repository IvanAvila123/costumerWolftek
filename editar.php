<?php
require('conexion.php');
$con = conectar();

$clienteId = $_POST['id'];
$razon_edit = $_POST['razon'];
$cuenta_edit = $_POST['cuenta'];
$id_cliente_edit = $_POST['id_cliente'];
$telefono_contacto_edit = $_POST['telefono_contacto'];
$representante_edit = $_POST['representante'];
$correo_edit = $_POST['correo'];
$ejecutivo_edit = $_POST['ejecutivo'];


$stmt = $con->prepare("UPDATE clientes SET razon = ?, cuenta = ?, id_cliente = ?, telefono_contacto = ?, representante = ?, correo = ?, ejecutivo = ? WHERE id = ?");
$stmt->bind_param("sssssssi", $razon_edit, $cuenta_edit, $id_cliente_edit, $telefono_contacto_edit, $representante_edit, $correo_edit, $ejecutivo_edit, $clienteId);

if ($stmt->execute()) {
  echo "Registro actualizado con éxito";
} else {
  echo "Error actualizando el registro: " . $stmt->error;
}

$stmt->close();
$con->close();

?>
