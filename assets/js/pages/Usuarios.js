let frmUsuario = document.querySelector('#formularioUsuario');

let tblUsuarios;

document.addEventListener('DOMContentLoaded', function () {

  tblUsuarios = $('#tblUsuarios').DataTable({
      ajax: {
          url: 'showUsuarios.php',
          dataSrc: 'data'
      },
      columns: [
          { data: 'id', responsivePriority: 1},
          { data: 'username'},
          { data: 'email'},
          { data: 'first_name'},
          { data: 'last_name'},
          { data: 'role'},
          {
            data: 'baja',
            render: function (data, type, row) {
                let baja = Number(data);
                return baja === 1 ? 'Dado de baja' : 'Activo';
            }
        },
          {
              data: null,
              render: function (data, type, row) {
                  // Agrega botones de acción a la columna
                  return '<button class="btn btn-primary btn-edit shadow btn-sm sharp mr-1"><i class="dripicons-pencil"></i></button> <button class="btn btn-danger btn-delete shadow btn-sm sharp"><i class="dripicons-trash"></i></button>';
              }
          },

          {
            data: null,
            render: function (data, type, row) {
                let baja = Number(row.baja);
                if (baja === 1) {
                    return '<button class="btn btn-success btn-activate shadow btn-sm sharp" data-id="' + row.id + '">Activar</button>';
                } else {
                    return '<button class="btn btn-danger btn-deactivate shadow btn-sm sharp" data-id="' + row.id + '">Desactivar</button>';
                }
            }
        }
      ],

      language: {
          url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
      },

      responsive: true
  });


  // Controlador de eventos click para el botón de desactivar
  $('#tblUsuarios').on('click', '.btn-deactivate', function () {
    let id = $(this).data('id');
    if (confirm('¿Estás seguro de que deseas dar de baja a este usuario?')) {
        deactivateUser(id);
    }
});



  function deactivateUser(id) {
      // Realiza una solicitud AJAX al servidor para dar de baja al usuario con el ID "id"
      $.ajax({
          type: 'POST',
          url: 'deactivateUser.php',
          data: { id: id },
          success: function () {
              // Recarga la tabla de usuarios después de que el usuario se da de baja
              tblUsuarios.ajax.reload();
          },
          error: function (error) {
              console.error('Error:', error);
          }
      });
  }

  $('#tblUsuarios').on('click', '.btn-activate', function () {
    let id = $(this).data('id');
    if (confirm('¿Estás seguro de que deseas reactivar a este usuario?')) {
        activateUser(id);
    }
});

  function activateUser(id) {
      // Realiza una solicitud AJAX al servidor para reactivar al usuario con el ID "id"
      $.ajax({
          type: 'POST',
          url: 'activateUser.php',
          data: { id: id },
          success: function () {
              // Recarga la tabla de usuarios después de reactivar el usuario
              tblUsuarios.ajax.reload();
          },
          error: function (error) {
              console.error('Error:', error);
          }
      });
  }


    // Agrega un controlador de eventos click para el botón de edición
$('#tblUsuarios').on('click', '.btn-edit', function () {
    // Obtén los datos de la fila seleccionada
    let data = tblUsuarios.row($(this).parents('tr')).data();
  
    // Llena el formulario modal con los datos de la fila seleccionada
    $('#edit-form input[name="id"]').val(data.id);
    $('#edit-form input[name="username"]').val(data.username);
    $('#edit-form input[name="email"]').val(data.email);
    $('#edit-form input[name="first_name"]').val(data.first_name);
    $('#edit-form input[name="last_name"]').val(data.last_name);
    $('#edit-form select[name="role"]').val(data.role);
  
    // Abre el formulario modal de edición
    $('#editarUsuario').modal('show');
  });
  
  // También puedes agregar un controlador para el envío del formulario
  $('#edit-form').on('submit', function (event) {
    event.preventDefault();
  
    // Obtén los datos del formulario
    let id = $(this).find('input[name="id"]').val();
    let username = $(this).find('input[name="username"]').val();
    let email = $(this).find('input[name="email"]').val();
    let first_name = $(this).find('input[name="first_name"]').val();
    let last_name = $(this).find('input[name="last_name"]').val();
    let role = $(this).find('select[name="role"]').val();
  
    // Envía una solicitud AJAX al servidor para actualizar los datos
    $.ajax({
      type: 'POST',
      url: 'editarUsuario.php',
      data: {
        id: id,
        username: username,
        email: email,
        first_name: first_name,
        last_name: last_name,
        role: role
      },
      success: function (response) {
        // Cierra el modal de edición
        $('#editarUsuario').modal('hide');
  
        // Recarga la tabla de usuarios o realiza las actualizaciones necesarias
        // Puedes agregar aquí lógica adicional según tus necesidades
      },
      error: function (error) {
        console.error('Error:', error);
      }
    });
  });

  // Agrega un controlador de eventos click para el botón de eliminación
$('#tblUsuarios').on('click', '.btn-delete', function () {
    // Obtén los datos de la fila seleccionada
    let data = tblUsuarios.row($(this).parents('tr')).data();
  
    // Muestra un modal de confirmación para la eliminación
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
      // Si el usuario confirma la eliminación, envía una solicitud AJAX al servidor
      $.ajax({
        type: 'POST',
        url: 'eliminarUsuario.php',
        data: {
          id: data.id // Envía el ID del usuario que se va a eliminar
        },
        success: function (response) {
          // Cierra el modal de eliminación si lo tienes abierto
          $('#eliminarUsuario').modal('hide');
  
          // Actualiza la tabla DataTables después de eliminar el registro
          tblUsuarios.ajax.reload();
        },
        error: function (error) {
          console.error('Error:', error);
        }
      });
    }
  });
  
  
});


frmUsuario.addEventListener('submit', function (event) {
    event.preventDefault();

    if (frmUsuario.username.value === '' || frmUsuario.password.value === '' || frmUsuario.email.value === '' || frmUsuario.first_name.value === '' || frmUsuario.last_name.value === '' || frmUsuario.role.value === '') {

    } else {
        let data = new FormData(frmUsuario);
        let url = 'guardarUsuario.php';

        fetch(url, {
            method: 'POST',
            body: data
        })
            .then(response => response.json())
            .then(res => {
                if (res.tipo == 'success') {
                    frmUsuario.reset();
                    tblUsuarios.ajax.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});


