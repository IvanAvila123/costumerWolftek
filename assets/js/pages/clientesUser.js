let frm = document.querySelector('#modalRegistro');


let tblClientesUser;

document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        tblClientesUser = $('#tblClientesUser').DataTable({
            ajax: {
                url: 'clientes.php',
                dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                { data: 'razon' },
                { data: 'cuenta' },
                { data: 'id_cliente' },
                { data: 'telefono_contacto' },
                { data: 'representante' },
                { data: 'correo' },
                { data: 'ejecutivo' },
                {
                    data: null,
                    render: function (data, type, row) {
                        // Botón para editar
                        var editarButton = '<button class="btn btn-primary" onclick="editar(' + data.id + ')">Editar</button>';

                        // Botón para eliminar
                        var eliminarButton = '<button class="btn btn-danger" onclick="eliminarCliente(' + data.id + ')">Eliminar</button>';

                        // Botón para ver
                        var verButton = '<button class="btn btn-info" onclick="redireccionarAAdminInformacion(' + data.id + ')">Ver</button>';

                        // Devuelve todos los botones
                        return editarButton + ' ' + eliminarButton + ' ' + verButton;
                    }
                }
            ],

            columnDefs: [
                {
                    // Oculta la primera columna (columna "id")
                    targets: 0,
                    visible: false
                }
            
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
            },
            responsive: true
        });
    });
});



function editar(id) {
    var data = tblClientesUser.rows().data().toArray().find(row => row.id == id);

    if (data) {
        // Asegúrate de que estás estableciendo el valor del campo oculto cuando llenas el formulario
        $('#clienteId').val(data.id);
        $('#razon_edit').val(data.razon);
        $('#cuenta_edit').val(data.cuenta);
        $('#id_cliente_edit').val(data.id_cliente);
        $('#telefono_contacto_edit').val(data.telefono_contacto);
        $('#representante_edit').val(data.representante);
        $('#correo_edit').val(data.correo);
        $('#ejecutivo_edit').val(data.ejecutivo);
    } else {
        console.error('No se encontró ninguna fila con el id ' + id);
    }

    // Muestra el formulario
    $('#editarClienteModal').modal('show');
}

document.getElementById('editarClienteForm').addEventListener('submit', function (e) {
    e.preventDefault();

    $.post('editar.php', $(this).serialize(), function (data) {
        // Aquí puedes manejar la respuesta del servidor
        // Por ejemplo, puedes recargar la tabla de DataTables
        tblClientesUser.ajax.reload();
    });
});

function eliminarCliente(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este cliente?")) {
        $.post('eliminar_cliente.php', { id: id }, function (data) {
            // Maneja la respuesta del servidor (puede mostrar un mensaje de éxito o error)
            console.log(data);

            // Recarga la tabla de DataTables para reflejar los cambios
            tblClientesUser.ajax.reload();
        });
    }
}


document.getElementById('formulario').addEventListener('submit', function (e) {
    e.preventDefault();

    $.post('guardar_clientes.php', $(this).serialize(), function (data) {


        tblClientesUser.ajax.reload();
    });
});

function redireccionarAAdminInformacion(id) {
    // Construye la URL con el parámetro 'id' que deseas pasar a 'adminInformacion.php'
    var url = 'userinformacion.php?id=' + id;
    
    // Redirige al usuario a la nueva página
    window.location.href = url;
}