let tblLineasUser;

document.addEventListener('DOMContentLoaded', function () {

    $(document).ready(function () {
        // Obtén el valor de 'id' de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        tblLineasUser = $('#tblLineasUser').DataTable({
            ajax: {
                // Usa el valor de 'id' en la URL
                url: "Getlineas.php?id=" + id,
                dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                { data: 'dn' },
                { data: 'fecha' },
                { data: 'plan' },
                { data: 'equipo' },
                {
                    data: null,
                    render: function (data, type, row) {
                        // Botón para editar
                        var editarButton = '<button class="btn btn-primary" onclick="editarLinea(' + data.id + ')">Editar</button>';

                        // Botón para eliminar
                        var eliminarButton = '<button class="btn btn-danger" onclick="eliminarLinea(' + data.id + ')">Eliminar</button>';

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
});



// Obtén el botón de guardar línea
const guardarNuevaLineaBtn = document.getElementById('guardarNuevaLinea');

// Agrega un evento de clic al botón de guardar línea
guardarNuevaLineaBtn.addEventListener('click', function (event) {
    // Previene el comportamiento predeterminado del botón
    event.preventDefault();

    // Obtén los valores de los campos del formulario
    const dn = document.getElementById('nuevoDn').value;
    const fecha = document.getElementById('nuevaFecha').value;
    const plan = document.getElementById('nuevoPlan').value;
    const equipo = document.getElementById('nuevoEquipo').value;
    const user_id = document.getElementsByName('user_id')[0].value;
    const cliente_id = document.getElementById('clienteId').value;
    const informacion_id = document.getElementsByName('informacion_id')[0].value;

    // Crea un objeto FormData para enviar los datos del formulario
    const formData = new FormData();
    formData.append('dn', dn);
    formData.append('fecha', fecha);
    formData.append('plan', plan);
    formData.append('equipo', equipo);
    formData.append('user_id', user_id);
    formData.append('cliente_id', cliente_id);
    formData.append('informacion_id', informacion_id);

    // Crea una instancia de XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Configura la solicitud POST
    xhr.open('POST', 'GuardarLinea.php', true);

    // Define la función de callback para manejar la respuesta del servidor
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Muestra la respuesta del servidor en la consola
            console.log(xhr.responseText);

            // Recarga la página actual
            location.reload();
        } else {
            console.error('Error:', xhr.status);
        }
    };

    // Envía la solicitud POST con los datos del formulario
    xhr.send(formData);
});


function editarLinea(id) {
    var data = tblLineasUser.rows().data().toArray().find(row => row.id == id);

    if (data) {
        // Asegúrate de que estás estableciendo el valor del campo oculto cuando llenas el formulario
        $('#linea_id').val(data.id);
        $('#editarDn').val(data.dn);
        $('#editarFecha').val(data.fecha);
        $('#editarPlan').val(data.plan);
        $('#editarEquipo').val(data.equipo);
    } else {
        console.error('No se encontró ninguna fila con el id ' + id);
    }

    // Muestra el formulario
    $('#modalEditarLinea').modal('show');
}

document.getElementById('formEditarLinea').addEventListener('submit', function (e) {
    e.preventDefault();

    $.post('editarLinea.php', $(this).serialize(), function (data) {
        // Aquí puedes manejar la respuesta del servidor
        // Por ejemplo, puedes recargar la tabla de DataTables
        tblLineasUser.ajax.reload();
    });
});


function eliminarLinea(id) {
    if (confirm("¿Estás seguro de que deseas eliminar esta Linea?")) {
        $.post('eliminar_lineas.php', { id: id }, function (data) {
            // Maneja la respuesta del servidor (puede mostrar un mensaje de éxito o error)
            console.log(data);

            // Recarga la tabla de DataTables para reflejar los cambios
            tblLineasUser.ajax.reload();
        });
    }
}