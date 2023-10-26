<?php
require_once('conexion.php');
$con = conectar();

        $user_id = $_POST['user_id'];
        $tipo = $_POST['tipo'];
        $cliente = $_POST['cliente'];
        $cuenta = $_POST['cuenta'];
        $numero_a_renovar = $_POST['numero_a_renovar'];
        $persona_encargada = $_POST['persona_encargada'];
        $domicilio_entrega = $_POST['domicilio_entrega'];
        $id_cliente = $_POST['id_cliente'];
        $numero_acuerdo = $_POST['numero_acuerdo'];
        $estado = $_POST['estado'];


        $sql = "INSERT INTO ventas_oportunidades (tipo, cliente, cuenta, numero_a_renovar, persona_encargada, domicilio_entrega, id_cliente, numero_acuerdo, estado, user_id) 
        VALUES ('$tipo', '$cliente', '$cuenta', '$numero_a_renovar', '$persona_encargada', '$domicilio_entrega', '$id_cliente', '$numero_acuerdo', '$estado', '$user_id')";

        if (mysqli_query($con, $sql)) {
            echo "Nueva Venta Guardado con éxito";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        
        mysqli_close($con);
        ?>
