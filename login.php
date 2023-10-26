<?php
require_once('conexion.php');
$con = conectar();

// Recoger los datos del formulario de inicio de sesión
$username = $_POST['username'];
$password = $_POST['password'];

// Buscar al usuario en la base de datos usando una sentencia preparada
$sql = "SELECT * FROM Users WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($user['baja'] == 0 && password_verify($password, $user['password'])) {
        // Iniciar la sesión
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];

        // Redirigir al usuario a la página correspondiente
        if ($user['role'] == 'admin') {
            header('Location: admin.php');
            exit();
        } else {
            header('Location: usuario.php');
            exit();
        }
    } else {
        // Verificar si el usuario está dado de baja
        if ($user['baja'] == 1) {
            // Usuario dado de baja, redirigir con mensaje de error
            $error_message = 'Usuario dado de baja';
            header('Location: index.php?error=baja');
            exit();
        } else {
            // Contraseña incorrecta
            $error_message = 'Contraseña incorrecta';
            header('Location: index.php?error=contrasena');
            exit();
        }
    }
} else {
    // Usuario no encontrado
    $error_message = 'Usuario no encontrado';
    header('Location: index.php?error=username');
    exit();
}

$con->close();

  
?>
