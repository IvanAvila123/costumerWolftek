<?php
require_once('conexion.php');

$con = conectar();

// Comprueba si la sesión ha sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Comprueba si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión, redirige al usuario a la página de inicio de sesión
    header('Location: login.php');
    exit();
}

// Ahora puedes acceder a $_SESSION['user_id'] de forma segura
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = $user_id";
$query = mysqli_query($con, $sql);

// Comprueba si la consulta fue exitosa
if (!$query) {
    die('Error en la consulta: ' . mysqli_error($con));
}

// Obtén los datos del usuario de la base de datos
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Costumer-wolftek</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/icono-logo.png">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <link href="assets/DataTable/datatables.min.css" rel="stylesheet">
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">

</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="assets/images/Wolftek.png" alt="" height="50">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="" height="40">
                </span>
            </a>

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="assets/images/Wolftek-light.png" alt="" height="50">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-light.png" alt="" height="40">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item">Navegacion</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end">4</span>
                            <span> Dashboards </span>
                        </a>
                        <div class="collapse" id="sidebarDashboards">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="Usuario.php">Clientes</a>
                                </li>
                                <li>
                                    <a href="ventasuser.php">Ventas/Oportuniddes</a>
                                </li>
                                <li>
                                    <a href="informesUser.php">Informes</a>
                                </li>

                                <li>
                                    <a href="renovacionesUser.php">Renovaciones/Renovaciones Anticipadas</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-title side-nav-item">Apps</li>

                    <li class="side-nav-item">
                        <a href="apps-chat.html" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Chat (Promixamente) </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="apps-file-manager.html" class="side-nav-link">
                            <i class="uil-folder-plus"></i>
                            <span> File Manager (Proximamente) </span>
                        </a>
                    </li>

                </ul>

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">

                        <li class="notification-list">
                            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="assets/images/imagen-usuario.png" alt="user-image" class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name"><?php echo $user['first_name'] . ' ' . $user['last_name'] ?></span>
                                    <span class="account-position"><?php echo $user['role'] ?></span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="logout.php" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>