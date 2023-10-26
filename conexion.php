<?php
function conectar(){
    $servername = "localhost";
    $user = "root";
    $password = "";
    $dbname = "costumerwolftek";

    // Crea conexión a la base de datos
    $con = new mysqli($servername, $user, $password, $dbname);

    // Verifica la conexión
    if ($con->connect_error) {
        die("Conexión Fallida: " . $con->connect_error);
    }

    return $con;
}
?>