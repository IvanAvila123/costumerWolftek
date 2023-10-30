<?php
session_start();

require_once('conexion.php');
$con = conectar();

// Verifica si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Si el usuario no ha iniciado sesión o no tiene el rol de 'admin', redirige a la página de inicio de sesión
    header('Location: index.php');
    exit(); // Asegúrate de que la redirección se ejecute antes de continuar
}

// Obtén el ID de usuario de la sesión
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Asigna 0 como valor predeterminado si no está definido

$sql = "SELECT * FROM clientes WHERE user_id = $user_id";
$query = mysqli_query($con, $sql);


// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Si el usuario no ha iniciado sesión o no tiene el rol de 'admin', redirige a la página de inicio de sesión
    header('Location: index.php');
    exit(); // Asegúrate de que la redirección se ejecute antes de continuar
}
?>

<?php
require_once('templates/header.php');
?>
<!-- Start Content-->
<div class="container-fluid">
    <div id="alertContainer"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <h3>Renovaciones Vencidas</h3>
                    <table class="table table-striped table-hover display nowrap" cellspacing="0" style="width:100%" id="tblRenovacion">
                        <thead>
                            <tr>
                                <th>Razon Social</th>
                                <th>Cuenta</th>
                                <th>ID Del Cliente</th>
                                <th>DN</th>
                                <th>Fecha Fin</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
              <br>
                <div class="table-responsive">
                <h3>Renovaciones Anticipadas T-1</h3>
                    <table class="table table-striped table-hover display nowrap" cellspacing="0" style="width:100%" id="tblRenovacionT1">
                        <thead>
                        <tr>
                                <th>Razon Social</th>
                                <th>Cuenta</th>
                                <th>ID Del Cliente</th>
                                <th>DN</th>
                                <th>Fecha Fin</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

                <br>
                <div class="table-responsive">
                <h3>Renovaciones Anticipadas</h3>
                    <table class="table table-striped table-hover display nowrap" cellspacing="0" style="width:100%" id="tblRenovacionAnticipada">
                        <thead>
                        <tr>
                                <th>Razon Social</th>
                                <th>Cuenta</th>
                                <th>ID Del Cliente</th>
                                <th>DN</th>
                                <th>Fecha Fin</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- container -->

</div>
<!-- content -->


<?php
require_once('templates/footer.php');
?>