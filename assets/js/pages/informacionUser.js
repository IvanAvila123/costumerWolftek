$(document).ready(function () {
    $('#informacionForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'guardar_informacion.php',
            data: formData,
            success: function (response) {
                $('#successAlert').fadeIn(); // Muestra la alerta
                setTimeout(function () {
                    $('#successAlert').fadeOut(); // Oculta la alerta después de un tiempo
                }, 5000); // Cambia 5000 a la duración deseada en milisegundos (en este caso, 5 segundos)
                $('#nuevaInformacion').modal('hide'); // Cierra el modal

                // Recarga la página inmediatamente
                location.reload();
            }
        });
    });
});


// Abrir el modal de edición al hacer clic en el botón "Editar Información"

$(document).ready(function () {

    // Escucha el evento click en el botón de edición
    $("button[data-target='#actualizarInformación']").click(function () {
        var clienteId = $(this).data("cliente-id");
        var userId = $(this).data("user-id");

        console.log("clienteId:", clienteId);
        console.log("userId:", userId);
        // Realiza una solicitud Ajax para obtener la información del cliente
        $.ajax({
            type: "GET",
            url: "obtener_informacion.php?cliente_id=" + clienteId + "&user_id=" + userId,
            success: function (response) {
                try {
                    var data = JSON.parse(response);

                    // Llena los campos del formulario con los datos recuperados
                    $("#fiscal_editar").val(data.fiscal);
                    $("#entrega_editar").val(data.entrega);
                    $("#rfc_editar").val(data.rfc);

                    // Abre el modal con los datos cargados
                    $("#actualizarInformación").modal("show");
                } catch (e) {
                    console.error("Error al analizar JSON:", e);
                }
            }
        });


    });
});



$(document).ready(function () {
    // Handle form submission
    $('#informacionFormEdit').submit(function (event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Get the form data
        var formData = $(this).serialize();

        // Send the data using AJAX
        $.ajax({
            url: 'editar_informacion.php', // Replace with the URL of your PHP script that updates the data
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response); // Muestra la respuesta completa en la consola
                if (response.success) {
                    // Datos actualizados exitosamente
                    alert('Datos actualizados exitosamente');
                    $('#actualizarInformación').modal('hide');
                    location.reload();
                } else {
                    // Error al actualizar datos
                    alert('Error al actualizar datos');
                }
            },

            error: function () {
                // Error sending the AJAX request
                alert('Error sending request');
            }
        });
    });
});