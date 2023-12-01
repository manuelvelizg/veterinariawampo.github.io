// Agrega esto en tu script.js
function loginUser() {
  // Tu lógica actual para validar el formulario

  // ... (puedes mantener el resto de tu función)

  // Agregamos la lógica para manejar la respuesta del servidor
  $.ajax({
    type: 'POST',
    url: 'ValidacionAcceso.php',
    data: $('form.login-form').serialize(),
    success: function (response) {
      response = JSON.parse(response);
      if (response.status === 'success') {
        showSuccessMessage(response.message);

        if (response.wait_for_ok) {
          // Esperar hasta que se indique "ok"
          Swal.fire({
            icon: 'info',
            title: 'Esperando confirmación',
            text: 'Presiona OK cuando estés listo',
            confirmButtonColor: '#17a2b8',
            confirmButtonText: 'Ok'
          }).then((result) => {
            if (result.isConfirmed) {
              // Asignar el valor a $response['rol_id']
              response.rol_id = 1;

              // Redirigir al menú de administrador
              window.location.href = '/Menu/Administrador.php';
            } else {
              // Puedes hacer algo si el usuario no confirma, por ejemplo, mostrar un mensaje o redirigir a otra página
              showErrorMessage('Operación cancelada');
            }
          });
        } else {
          // No se espera, asignar directamente el valor a $response['rol_id']
          if (response.rol_id === 1) {
            // Redirigir al menú de administrador
            window.location.href = '/Menu/Administrador.php';
          } else if (response.rol_id === 2) {
            // Redirigir al menú de usuario
            window.location.href = '/ruta-del-menu-usuario';
          }
        }
      } else {
        showErrorMessage(response.message);
      }

    },
    error: function () {
      showErrorMessage('Error de conexión con el servidor.');
    }
  });

  // Devolvemos false para evitar que el formulario se envíe normalmente
  return false;
}

function showSuccessMessage(message) {
  Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: message,
    confirmButtonColor: '#28a745',
    confirmButtonText: 'Ok'
  });
}

function showErrorMessage(message) {
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: message,
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'Ok'
  });
}