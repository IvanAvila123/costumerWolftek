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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">
            Nuevo Clientes
        </button>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover display nowrap" cellspacing="0" style="width:100%" id="tblClientesAdmin">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Razon Social</th>
                                <th>Cuenta</th>
                                <th>ID Del Cliente</th>
                                <th>Telefono</th>
                                <th>Representante</th>
                                <th>Correo</th>
                                <th>Ejecutivo</th>
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

<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Guardar Clientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <div class="row">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="hidden" id="id" name="id">
                        
                        <div class="col-md-6">
                            <label for="razon"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-store"></i></span>
                                <input type="text" class="form-control" id="razon" name="razon" placeholder="Razon Social">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="cuenta"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-wallet"></i></span>
                                <input type="text" class="form-control" id="cuenta" name="cuenta" placeholder="Cuenta Azul">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="id_cliente"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-checkmark"></i></span>
                                <input type="text" class="form-control" id="id_cliente" name="id_cliente" placeholder="Id Del Cliente">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono_contacto"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-phone"></i></span>
                                <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" placeholder="Telefono">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="representante"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user"></i></span>
                                <input type="text" class="form-control" id="representante" name="representante" placeholder="Representante Legal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="correo"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-mail"></i></span>
                                <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electronico">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="ejecutivo"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user"></i></span>
                                <input type="text" class="form-control" id="ejecutivo" name="ejecutivo" placeholder="Ejecutivo">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editarClienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editarClienteForm">

                    <div class="row">
                    <input type="hidden" id="clienteId" name="id">   
                        <div class="col-md-6">
                            <label for="razon_edit"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-store"></i></span>
                                <input type="text" class="form-control" id="razon_edit" name="razon" placeholder="Razon Social">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="cuenta_edit"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-wallet"></i></span>
                                <input type="text" class="form-control" id="cuenta_edit" name="cuenta" placeholder="Cuenta Azul">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="id_cliente_edit"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-checkmark"></i></span>
                                <input type="text" class="form-control" id="id_cliente_edit" name="id_cliente" placeholder="Id Del Cliente">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono_contacto_edit"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-phone"></i></span>
                                <input type="text" class="form-control" id="telefono_contacto_edit" name="telefono_contacto" placeholder="Telefono">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="representante_edit"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user"></i></span>
                                <input type="text" class="form-control" id="representante_edit" name="representante" placeholder="Representante Legal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="correo_edit"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-mail"></i></span>
                                <input type="text" class="form-control" id="correo_edit" name="correo" placeholder="Correo Electronico">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="ejecutivo_edit"></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user"></i></span>
                                <input type="text" class="form-control" id="ejecutivo_edit" name="ejecutivo" placeholder="Ejecutivo">
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Editar Cliente</button>
            </div>
            </form>
        </div>
    </div>
</div>


<?php
require_once('templates/footer.php');
?>