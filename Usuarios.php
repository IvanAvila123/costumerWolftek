<?php
session_start();

require_once('conexion.php');
$con = conectar();

// Verifica si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Si el usuario no ha iniciado sesión o no tiene el rol de 'admin', redirige a la página de inicio de sesión
    header('Location: login.php');
    exit(); // Asegúrate de que la redirección se ejecute antes de continuar
}

// Obtén el ID de usuario de la sesión
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Asigna 0 como valor predeterminado si no está definido

$sql = "SELECT * FROM clientes WHERE user_id = $user_id";
$query = mysqli_query($con, $sql);

$clientes = mysqli_fetch_assoc($query);


// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Si el usuario no ha iniciado sesión o no tiene el rol de 'admin', redirige a la página de inicio de sesión
    header('Location: login.php');
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUsuario">
            Nuevo Usuario
        </button>

        <a href="enviarCorreo.php" class="btn btn-warning">Mandar correos</a>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover display nowrap" cellspacing="0" style="width:100%" id="tblUsuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Nombre(s)</th>
                                <th>Apellidos</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Action</th>
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

<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioUsuario">
                    <div class="row">

                        <div class="col-md-6">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-weight"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-mail"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="first_name">Nombres</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nombres">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="last_name">Apellidos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="role">Rol</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-scale"></i></span>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="admin">Administrador</option>
                                    <option value="user">Usuario</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar Usuario</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    <div class="row">

                    <input type="hidden" id="id" name="id">

                        <div class="col-md-6">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-mail"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="first_name">Nombres</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nombres">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="last_name">Apellidos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="role">Rol</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-scale"></i></span>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="admin">Administrador</option>
                                    <option value="user">Usuario</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Editar Usuario</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once('templates/footer.php');
?>