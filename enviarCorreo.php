<?php
require_once('conexion.php');
$con = conectar();
if (!$con) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Obtener la fecha actual
$hoy = date('Y-m-d');

// Calcular la fecha de renovación anticipada (3 meses después de hoy)
$renovacionAnticipada = date('Y-m-d', strtotime('+3 months', strtotime($hoy)));

// Consultar las cuentas que se pueden renovar para cada usuario
$queryUsuarios = "SELECT * FROM users";
$resultUsuarios = mysqli_query($con, $queryUsuarios);

while ($rowUsuario = mysqli_fetch_assoc($resultUsuarios)) {
    // Si el usuario está dado de baja, saltar al siguiente usuario
    if ($rowUsuario['baja'] == 1) {
        continue;
    }

    $userId = $rowUsuario['id'];
    $userEmail = $rowUsuario['email'];

    // Consultar las cuentas que se pueden renovar para el usuario actual
    $queryRenovacion = "SELECT * FROM clientes INNER JOIN lineas ON clientes.id = lineas.cliente_id WHERE lineas.fecha <= '$hoy' AND clientes.user_id = $userId";
    $resultRenovacion = mysqli_query($con, $queryRenovacion);

    // Consultar las renovaciones anticipadas para el usuario actual (con un máximo de 3 meses en el futuro)
    $queryRenovacionAnticipada = "SELECT * FROM clientes INNER JOIN lineas ON clientes.id = lineas.cliente_id WHERE lineas.fecha BETWEEN '$hoy' AND DATE_ADD('$hoy', INTERVAL 3 MONTH) AND clientes.user_id = $userId";
    $resultRenovacionAnticipada = mysqli_query($con, $queryRenovacionAnticipada);

    // Inicializa las variables HTML fuera del bucle
    $htmlCuentasRenovar = '';
    $htmlRenovacionesAnticipadas = '';

    while ($rowRenovacion = mysqli_fetch_assoc($resultRenovacion)) {
        // Construye el HTML para "Cuentas que se pueden renovar"
        $htmlCuentasRenovar .= "<tr>";
        $htmlCuentasRenovar .= "<td>" . $rowRenovacion['id'] . "</td>";
        $htmlCuentasRenovar .= "<td>" . $rowRenovacion['razon'] . "</td>";
        $htmlCuentasRenovar .= "<td>" . $rowRenovacion['cuenta'] . "</td>";
        $htmlCuentasRenovar .= "<td>" . $rowRenovacion['dn'] . "</td>";
        $htmlCuentasRenovar .= "<td>" . $rowRenovacion['fecha'] . "</td>";
        $htmlCuentasRenovar .= "</tr>";
    }

    while ($rowRenovacionAnticipada = mysqli_fetch_assoc($resultRenovacionAnticipada)) {
        // Construye el HTML para "Renovaciones anticipadas"
        $htmlRenovacionesAnticipadas .= "<tr>";
        $htmlRenovacionesAnticipadas .= "<td>" . $rowRenovacionAnticipada['id'] . "</td>";
        $htmlRenovacionesAnticipadas .= "<td>" . $rowRenovacionAnticipada['razon'] . "</td>";
        $htmlRenovacionesAnticipadas .= "<td>" . $rowRenovacionAnticipada['cuenta'] . "</td>";
        $htmlRenovacionesAnticipadas .= "<td>" . $rowRenovacionAnticipada['dn'] . "</td>";
        $htmlRenovacionesAnticipadas .= "<td>" . $rowRenovacionAnticipada['fecha'] . "</td>";
        $htmlRenovacionesAnticipadas .= "</tr>";
    }

    // Después del bucle, verifica si hay datos y construye el correo electrónico
    if (!empty($htmlCuentasRenovar)) {
        // Construye la tabla "Cuentas que se pueden renovar"
        $htmlCuentasRenovar = "<h1>Cuentas que se pueden renovar:</h1><table><tr><th>ID</th><th>Razón</th><th>Cuenta</th><th>DN</th><th>Fecha</th></tr>" . $htmlCuentasRenovar . "</table>";
    }

    if (!empty($htmlRenovacionesAnticipadas)) {
        // Construye la tabla "Renovaciones anticipadas"
        $htmlRenovacionesAnticipadas = "<h1>Renovaciones anticipadas:</h1><table><tr><th>ID</th><th>Razón</th><th>Cuenta</th><th>DN</th><th>Fecha</th></tr>" . $htmlRenovacionesAnticipadas . "</table>";
    }
    // Concatena ambas tablas en el cuerpo del mensaje en el orden invertido
    $html = $htmlRenovacionesAnticipadas . $htmlCuentasRenovar;

    // Configuración SMTP para Gmail
    $smtp_username = 'ivanavilar456@gmail.com'; // Tu dirección de Gmail
    $smtp_password = 'savx mqxn gohk hlph'; // Tu contraseña de Gmail
    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", "587");
    ini_set('sendmail_from', 'ivanavilar456@gmail.com'); // Cambia esto a tu dirección de Gmail

    $to = $userEmail;
    $subject = "Cuentas para renovar";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ivanavilar456@gmail.com"; // Cambia esto a tu dirección de Gmail

    if (mail($to, $subject, $html, $headers, "-f " . $smtp_username)) {
        echo "Correo enviado con éxito a $to<br>";
    } else {
        echo "Error al enviar el correo a $to<br>";
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($con);
?>









