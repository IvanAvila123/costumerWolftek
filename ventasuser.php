<?php
session_start();

require_once('conexion.php');
$con = conectar();

// Verifica si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    // Si el usuario no ha iniciado sesión o no tiene el rol de 'admin', redirige a la página de inicio de sesión
    header('Location: login.php');
    exit(); // Asegúrate de que la redirección se ejecute antes de continuar
}

// Obtén el ID de usuario de la sesión
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Asigna 0 como valor predeterminado si no está definido

$sql = "SELECT * FROM ventas_oportunidades WHERE user_id = $user_id";
$query = mysqli_query($con, $sql);

$clientes = mysqli_fetch_assoc($query);


// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    // Si el usuario no ha iniciado sesión o no tiene el rol de 'admin', redirige a la página de inicio de sesión
    header('Location: login.php');
    exit(); // Asegúrate de que la redirección se ejecute antes de continuar
}
?>



<?php
require_once('templates/header-user.php');
?>
<!-- Start Content-->
<div class="container-fluid">
    <div id="alertContainer"></div>
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalVenta">
            Nueva Venta
        </button>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover display nowrap" cellspacing="0" style="width:100%" id="tblVentas">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo De Venta</th>
                                <th>cliente</th>
                                <th>Cuenta</th>
                                <th>Numero(s) a Renovar</th>
                                <th>Persona Autorizada</th>
                                <th>Domicilio De Entrega</th>
                                <th>ID</th>
                                <th>Acuerdo</th>
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

<div class="modal fade" id="ModalVenta" tabindex="-1" role="dialog" aria-labelledby="modalRenovacionLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Ingresar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="venta-form">
                    <div class="row">

                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" id="id" name="id">

                    <div class="col-md-6">
                            <label for="tipo">Tipo De Venta</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-scale"></i></span>
                                <select name="tipo" id="tipo" class="form-control" required>
                                    <option value="renovacion">Renovacion</option>
                                    <option value="adicion">Adicion</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="cliente">Cliente</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user"></i></span>
                                <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Cliente">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="cuenta">Cuenta</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-mail"></i></span>
                                <input type="text" class="form-control" id="cuenta" name="cuenta" placeholder="Cuenta">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_a_renovar">Numeros a renovar</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="numero_a_renovar" name="numero_a_renovar" placeholder="Numeros">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="persona_encargada">Persona Autorizada</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="persona_encargada" name="persona_encargada" placeholder="Persona Autorizada">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="domicilio_entrega">Domicilio De Entrega</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="domicilio_entrega" name="domicilio_entrega" placeholder="Domicilio Donde Se Va Entregar">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="id_cliente">ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="id_cliente" name="id_cliente" placeholder="ID Del Cliente">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_acuerdo">N° De Acuerdo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="numero_acuerdo" name="numero_acuerdo" placeholder="Numero De Acuerdo">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="estado">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-scale"></i></span>
                                <select name="estado" id="estado" class="form-control" required>
                                    <option value="Revision">Revision</option>
                                    <option value="Captura">Captura</option>
                                    <option value="Verificacion De Credito">Verficacion De Credito</option>
                                    <option value="Asignacion/equipo">Asignacion/Equipo</option>
                                    <option value="Envios/por Confirmar">Envios/por Confirmar</option>
                                    <option value="Envios/en ruta">Envios/en ruta</option>
                                    <option value="Orden entregada">Orden Entregada</option>

                                </select>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="guardarRenovacion">Guardar Venta</button>
            </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="editVenta" tabindex="-1" role="dialog" aria-labelledby="modalRenovacionLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Edita Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="venta-formEdit">
                    <div class="row">

                    <input type="hidden" id="ventaId" name="id">

                    <div class="col-md-6">
                            <label for="tipoEdit">Tipo De Venta</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-scale"></i></span>
                                <select name="tipo" id="tipoEdit" class="form-control" required>
                                    <option value="renovacion">Renovacion</option>
                                    <option value="adicion">Adicion</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="clienteEdit">Cliente</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user"></i></span>
                                <input type="text" class="form-control" id="clienteEdit" name="cliente" placeholder="Cliente">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="cuentaEdit">Cuenta</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-mail"></i></span>
                                <input type="text" class="form-control" id="cuentaEdit" name="cuenta" placeholder="Cuenta">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_a_renovarEdit">Numeros a renovar</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="numero_a_renovarEdit" name="numero_a_renovar" placeholder="Numeros">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="persona_encargadaEdit">Persona Autorizada</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="persona_encargadaEdit" name="persona_encargada" placeholder="Persona Autorizada">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="domicilio_entregaEdit">Domicilio De Entrega</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="domicilio_entregaEdit" name="domicilio_entrega" placeholder="Domicilio Donde Se Va Entregar">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="id_clienteEdit">ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="id_clienteEdit" name="id_cliente" placeholder="ID Del Cliente">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_acuerdoEdit">N° De Acuerdo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-user-group"></i></span>
                                <input type="text" class="form-control" id="numero_acuerdoEdit" name="numero_acuerdo" placeholder="Numero De Acuerdo">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="estadoEdit">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="dripicons-scale"></i></span>
                                <select name="estado" id="estadoEdit" class="form-control" required>
                                    <option value="Revision">Revision</option>
                                    <option value="Captura">Captura</option>
                                    <option value="Verificacion De Credito">Verficacion De Credito</option>
                                    <option value="Asignacion/equipo">Asignacion/Equipo</option>
                                    <option value="Envios/por Confirmar">Envios/por Confirmar</option>
                                    <option value="Envios/en ruta">Envios/en ruta</option>
                                    <option value="Orden entregada">Orden Entregada</option>

                                </select>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Editar Venta</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once('templates/footer-user.php');
?>