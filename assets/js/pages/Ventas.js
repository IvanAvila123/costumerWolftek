let tblVentas;

$(document).ready(function () {
    tblVentas = $('#tblVentas').DataTable({
        ajax: {
            url: 'getVenta.php',
            dataSrc: 'data'
        },
        columns: [
            { data: 'id' },
            { data: 'tipo' },
            { data: 'cliente' },
            { data: 'cuenta' },
            { data: 'numero_a_renovar' },
            { data: 'persona_encargada' },
            { data: 'domicilio_entrega' },
            { data: 'id_cliente' },
            { data: 'numero_acuerdo' },
            { data: 'estado' },
            {
                data: null,
                render: function (data, type, row) {
                    // Botón para editar
                    var editarButton = '<button class="btn btn-primary" onclick="editar(' + data.id + ')">Editar</button>';

                    // Botón para eliminar
                    var eliminarButton = '<button class="btn btn-danger" onclick="eliminarVenta(' + data.id + ')">Eliminar</button>';

                    // Devuelve todos los botones
                    return editarButton + ' ' + eliminarButton;
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


document.getElementById('venta-form').addEventListener('submit', function (e) {
    e.preventDefault();

    $.post('guardarVenta.php', $(this).serialize(), function (data) {


        tblVentas.ajax.reload();
    });
});


function editar(id) {
    var data = tblVentas.rows().data().toArray().find(row => row.id == id);

    if (data) {
        // Asegúrate de que estás estableciendo el valor del campo oculto cuando llenas el formulario
        $('#ventaId').val(data.id);
        $('#tipoEdit').val(data.tipo);
        $('#clienteEdit').val(data.cliente);
        $('#cuentaEdit').val(data.cuenta);
        $('#numero_a_renovarEdit').val(data.numero_a_renovar);
        $('#persona_encargadaEdit').val(data.persona_encargada);
        $('#domicilio_entregaEdit').val(data.domicilio_entrega);
        $('#id_clienteEdit').val(data.id_cliente);
        $('#numero_acuerdoEdit').val(data.numero_acuerdo);
        $('#estadoEdit').val(data.estado);
    } else {
        console.error('No se encontró ninguna fila con el id ' + id);
    }

    // Muestra el formulario
    $('#editVenta').modal('show');
}

document.getElementById('venta-formEdit').addEventListener('submit', function (e) {
    e.preventDefault();

    $.post('editarVenta.php', $(this).serialize(), function (data) {
        // Aquí puedes manejar la respuesta del servidor
        // Por ejemplo, puedes recargar la tabla de DataTables
        tblVentas.ajax.reload();
    });
});

function eliminarVenta(id){
    if (confirm("¿Estás seguro de que deseas eliminar esta Venta?")) {
        $.post('eliminar_venta.php', { id: id }, function (data) {
            // Maneja la respuesta del servidor (puede mostrar un mensaje de éxito o error)
            console.log(data);

            // Recarga la tabla de DataTables para reflejar los cambios
            tblVentas.ajax.reload();
        });
    }
}




