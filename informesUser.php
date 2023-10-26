<?php
session_start();

require_once('conexion.php');
$con = conectar();

// Verifica si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    // Si el usuario no ha iniciado sesión o no tiene el rol de 'admin', redirige a la página de inicio de sesión
    header('Location: index.php');
    exit(); // Asegúrate de que la redirección se ejecute antes de continuar
}

// Obtén el ID de usuario de la sesión
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Asigna 0 como valor predeterminado si no está definido

$sql = "SELECT * FROM clientes WHERE user_id = $user_id";
$query = mysqli_query($con, $sql);


// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    // Si el usuario no ha iniciado sesión o no tiene el rol de 'admin', redirige a la página de inicio de sesión
    header('Location: index.php');
    exit(); // Asegúrate de que la redirección se ejecute antes de continuar
}
?>

<?php
require_once('templates/header-user.php');
?>
<!-- Start Content-->
<div class="container-fluid">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalExcel">
        Agregar Informe
    </button>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <h5 class="mb-2">Informes De Venta</h5>

                            <div class="row mx-n1 g-0">
                                <?php
                                $username = $_SESSION['username'];

                                // Obtener la lista de archivos en el directorio del usuario
                                $directorio = 'uploads/' . $username;
                                $archivos = scandir($directorio);

                                // Mostrar los enlaces a los archivos
                                foreach ($archivos as $archivo) {
                                    if ($archivo != '.' && $archivo != '..') {
                                        $rutaArchivo = $directorio . '/' . $archivo;
                                        echo '<div class="col-xxl-3 col-lg-6">
                                            <div class="card m-1 shadow-none border">
                                                <div class="p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar-sm">
                                                                <span class="avatar-title bg-light text-secondary rounded">
                                                                    <i class="mdi mdi-folder-zip font-16"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col ps-0">
                                                        <a href="#" onclick="leerExcel(\'' . $rutaArchivo . '\')" class="text-muted fw-bold">' . $archivo . '</a>;
                                                            <p class="mb-0 font-13">2.3 MB</p>
                                                        </div>
                                                    </div> <!-- end row -->
                                                </div> <!-- end .p-2-->
                                            </div> <!-- end col -->
                                        </div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end col-->';

</div>
</div>
</div>
</div>
</div>
</div>

<!-- content -->

<div class="modal fade" id="modalExcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Ingresar Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="subir_excel.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="archivo" accept=".xlsx">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar Excel</button>
            </div>
            </form>
        </div>
    </div>
</div>


<?php
require_once('templates/footer-user.php');
?>