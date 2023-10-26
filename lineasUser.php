<?php
// Incluye la configuración de la base de datos
require_once('conexion.php');
$con = conectar();



// Inicia la sesión
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_SESSION['user_id'])) {
        // La sesión está configurada, puedes obtener el valor de 'user_id'
        $user_id = $_SESSION['user_id'];

        // Realiza una consulta SQL para obtener la información del cliente
        $stmt = mysqli_prepare($con, "SELECT clientes.razon, informacion.id AS informacion_id FROM informacion INNER JOIN clientes ON clientes.id = informacion.cliente_id WHERE informacion.cliente_id = ? AND informacion.user_id = ?;");
        mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);

            if ($fila) {
                $razon = $fila['razon'];
                $informacion_id = $fila['informacion_id'];
                // Ahora tienes la 'razon' y 'informacion_id' específicos para el cliente y el usuario
                // Puedes usar estos valores en futuras consultas o procesamientos.
            } else {
                echo 'No se encontraron datos del cliente para los valores especificados';
            }
        } else {
            // Maneja el caso en que no se encontraron datos del cliente
            echo 'No se encontraron datos del cliente';
        }

        // Realiza una consulta SQL para obtener las líneas
        $stmt = mysqli_prepare($con, "SELECT id AS linea_id FROM lineas WHERE cliente_id = ? AND user_id = ?;");
        mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);

            if ($fila) {
                $linea_id = $fila['linea_id'];
                // Ahora tienes el 'id' de la línea específico para el cliente y el usuario
                // Puedes usar este valor en futuras consultas o procesamientos.
            } else {
                echo 'No se encontraron líneas para los valores especificados';
            }
        } else {
            // Maneja el caso en que no se encontraron líneas
            echo 'No se encontraron líneas';
        }
    } else {
        // La sesión no está configurada, muestra un mensaje de error o redirige al usuario a la página de inicio de sesión
        echo 'La sesión no está configurada. Inicia sesión primero.';
        // O redirige al usuario a la página de inicio de sesión
        header('Location: index.php');
        exit; // Detiene la ejecución del script
    }
}



?>



<?php
require_once('templates/header-user.php');
?>

<!-- Start Content -->
<div class="container-fluid">
    <div id="alertContainer"></div>
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaLinea">
            Nueva Linea
        </button>
        <div class="card">
            <h2><?php echo $razon;?></h2>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover display nowrap" cellspacing="0" style="width:100%" id="tblLineasUser">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DN</th>
                                <th>Fecha</th>
                                <th>Plan</th>
                                <th>Equipo</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contenido de la tabla -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Agregar Nueva Línea -->
<div class="modal fade" id="modalNuevaLinea" tabindex="-1" role="dialog" aria-labelledby="modalNuevaLineaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaLineaLabel">Nueva Línea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formNuevaLinea" method="post">

                    <input type="hidden" id="clienteId" name="cliente_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="informacion_id" value="<?php echo $informacion_id; ?>">


                    <div class="form-group">
                        <label for="nuevoDn">DN</label>
                        <input type="text" class="form-control" id="nuevoDn" name="dn">
                    </div>
                    <div class="form-group">
                        <label for="nuevaFecha">Fecha</label>
                        <input type="date" class="form-control" id="nuevaFecha" name="fecha">
                    </div>
                    <div class="form-group">
                        <label for="nuevoPlan">Plan</label>
                        <input type="text" class="form-control" id="nuevoPlan" name="plan">
                    </div>
                    <div class="form-group">
                        <label for="nuevoEquipo">Equipo</label>
                        <input type="text" class="form-control" id="nuevoEquipo" name="equipo">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="guardarNuevaLinea">Guardar Linea</button>
            </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarLinea" tabindex="-1" role="dialog" aria-labelledby="modalEditarLineaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLineaLabel">Editar Línea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarLinea" method="post">

                    <input type="hidden" id="linea_id" name="id" value="<?php echo $linea_id; ?>">
                    <input type="hidden" id="clienteId" name="cliente_id" value="<?php echo $id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="informacion_id" value="<?php echo $informacion_id; ?>">


                    <div class="form-group">
                        <label for="editarDn">DN</label>
                        <input type="text" class="form-control" id="editarDn" name="dn">
                    </div>
                    <div class="form-group">
                        <label for="editarFecha">Fecha</label>
                        <input type="date" class="form-control" id="editarFecha" name="fecha">
                    </div>
                    <div class="form-group">
                        <label for="editarPlan">Plan</label>
                        <input type="text" class="form-control" id="editarPlan" name="plan">
                    </div>
                    <div class="form-group">
                        <label for="editarEquipo">Equipo</label>
                        <input type="text" class="form-control" id="editarEquipo" name="equipo">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="editarLinea">Editar Linea</button>
            </div>
            </form>

        </div>
    </div>
</div>

<?php
require_once('templates/footer-user.php');
?>