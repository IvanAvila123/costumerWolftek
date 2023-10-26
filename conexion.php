<?php

function conectar(){
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "costumerwolftek";

//crea conexion a la base de datos

$con = new mysqli($servername, $user, $password, $dbname);

return $con;

//verifica la conexion

if ($con->connect_error) {
    die("Conexion Fallida" . $con->connect_error);
}
echo "Conexion Exitosamente";
}
?>