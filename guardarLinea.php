<?php
// Incluye la configuración de la base de datos
require_once('conexion.php');
$con = conectar();

// Verifica si la solicitud es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si las claves están presentes en el array $_POST
    if (isset($_POST['dn'], $_POST['fecha'], $_POST['plan'], $_POST['equipo'], $_POST['user_id'], $_POST['cliente_id'], $_POST['informacion_id'])) {
        // Obtén los datos del formulario
        $dn = $_POST['dn'];
        $fecha = $_POST['fecha'];
        $plan = $_POST['plan'];
        $equipo = $_POST['equipo'];
        $user_id = $_POST['user_id'];
        $cliente_id = $_POST['cliente_id'];
        $informacion_id = $_POST['informacion_id'];

        // Realiza la inserción en la tabla 'informacion'
        $sql = "INSERT INTO lineas (dn, fecha, plan, equipo, user_id, cliente_id, informacion_id ) 
                VALUES ('$dn', '$fecha', '$plan', '$equipo', $user_id, $cliente_id, $informacion_id)";
        
        if (mysqli_query($con, $sql)) {
            echo "Linea guardada con éxito.";
        } else {
            echo "Error al guardar la Linea: " . mysqli_error($con);
        }
    } else {
        echo "Faltan algunos datos.";
    }
} else {
    echo "Acceso no autorizado.";
}
?>






