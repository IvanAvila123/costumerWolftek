<?php
// Comprobar si se ha subido un archivo
if (isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];

    // Comprobar si el archivo es un archivo Excel
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    if ($extension != 'xlsx') {
        die('El archivo no es un archivo Excel válido.');
    }

    // Obtener el nombre de usuario del usuario autenticado
    // Asegúrate de que el usuario esté autenticado antes de hacer esto
    session_start();
    $username = $_SESSION['username'];

    // Crear un directorio para el usuario si no existe
    $directorio = 'uploads/' . $username;
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Mover el archivo al directorio del usuario
    $destino = $directorio . '/' . $archivo['name'];
    if (move_uploaded_file($archivo['tmp_name'], $destino)) {
        echo 'El archivo se ha subido correctamente.';
    } else {
        echo 'Hubo un error al subir el archivo.';
    }
} else {
    echo 'No se ha subido ningún archivo.';
}
