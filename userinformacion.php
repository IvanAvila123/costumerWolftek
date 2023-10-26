<?php
// Incluye la configuración de la base de datos
require_once('conexion.php');
$con = conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    // Obtener el user_id de la sesión del usuario
    session_start();
    $user_id = $_SESSION['user_id'];

    // Realiza una consulta SQL para obtener la información del cliente
    $sql = "SELECT clientes.razon, informacion.fiscal, informacion.entrega, informacion.rfc, informacion.cliente_id FROM informacion INNER JOIN clientes ON clientes.id = informacion.cliente_id WHERE informacion.cliente_id = $id AND informacion.user_id = $user_id";
    $resultado = mysqli_query($con, $sql);

    if ($resultado) {
        $informacionCliente = mysqli_fetch_assoc($resultado);
        $razon = $informacionCliente['razon'];
        // Ahora tienes el 'razon' específico para el cliente y el usuario
        // Puedes usar este valor en futuras consultas o procesamientos.
    } else {
        // Maneja el caso en que no se encontraron datos del cliente
        echo 'No se encontraron datos del cliente';
    }
}

?>




<?php
require_once('templates/header-user.php');
?>
<!-- Start Content-->
<div class="container mt-4 shadow-lg p-3 mb-5 bg-body rounded">
        <h2><?php echo $razon;?></h2>
    <div class="alert alert-success" role="alert" id="successAlert" style="display: none;">
        La información se guardó correctamente.
    </div>

    <br>
    <div class="row g-3">
        <?php
        if ($informacionCliente !== null) {
            // Mostrar los datos del cliente en el HTML
            echo '<div class="col-md-6">';
            echo '<label for="fiscal" class="form-label h3">' . 'Direccion Fiscal' . '</label>';
            echo '<textarea class="form-control" id="fiscal">' . $informacionCliente['fiscal'] . '</textarea>';
            echo '</div>';

            echo '<div class="col-md-6">';
            echo '<label for="entrega" class="form-label h3">' . 'Direccion De Entrega' . '</label>';
            echo '<textarea class="form-control" id="entrega">' . $informacionCliente['entrega'] . '</textarea>';
            echo '</div>';

            echo '<div class="col-md-6">';
            echo '<label for="rfc" class="form-label h3">' . 'RFC' . '</label>';
            echo '<textarea class="form-control" id="rfc">' . $informacionCliente['rfc'] . '</textarea>';
            echo '</div>';
        } else {
            // Ocultar la información del cliente
            echo '<div class=" text-center"><h2>No Se Encontro Informacion Del Cliente Favor De Capturarlo</h2></div>';
        }
        ?>
        <br>
        <div class="col-12">
            <?php
            if ($informacionCliente === null) {
                // Mostrar el botón "Nueva Información" solo si no hay información del cliente
                echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaInformacion">Nueva Información</button>';
            }
            ?>

            <?php
            if ($informacionCliente !== null) {
                // Mostrar el botón "Actualizar Información" solo si ya existe información del cliente
                echo '<button type="button" class="btn btn-info" data-cliente-id="' . $id . '" data-user-id="' . $user_id . '" data-toggle="modal" data-target="#actualizarInformación">
                Editar Información
                </button>';
            }
            ?>

            <?php
            if ($informacionCliente !== null) {
                echo '<a href="lineasUser.php?id=' . $id . '" class="btn btn-primary">Lineas</a>';
            }
            ?>

        </div>
    </div>

    <!-- Modal para nueva información -->
    <div class="modal fade" id="nuevaInformacion" tabindex="-1" aria-labelledby="nuevaInformacionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaInformacionLabel">Nueva Información del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="informacionForm">
                        <div class="mb-3">
                            <label for="fiscal" class="form-label">Dirección Fiscal</label>
                            <textarea class="form-control" id="fiscal" name="fiscal" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="entrega" class="form-label">Dirección de Entrega</label>
                            <textarea class="form-control" id="entrega" name="entrega" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="rfc" class="form-label">RFC</label>
                            <input type="text" class="form-control" id="rfc" name="rfc" required>
                        </div>
                        <input type="hidden" name="cliente_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <button type="submit" class="btn btn-primary">Guardar Informacion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="actualizarInformación" tabindex="-1" aria-labelledby="actualizarInformacionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actualizarInformacionLabel">Actualizar Información del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="informacionFormEdit">
                        <div class="mb-3">
                            <label for="fiscal" class="form-label">Dirección Fiscal</label>
                            <textarea class="form-control" id="fiscal_editar" name="fiscal" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="entrega" class="form-label">Dirección de Entrega</label>
                            <textarea class="form-control" id="entrega_editar" name="entrega" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="rfc" class="form-label">RFC</label>
                            <input type="text" class="form-control" id="rfc_editar" name="rfc" required>
                        </div>
                        <input type="hidden" name="cliente_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <button type="submit" class="btn btn-primary">Editar Informacion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    require_once('templates/footer-user.php');
    ?>