$(function () {

    init();

    function init() {
        let sesion = JSON.parse(sessionStorage.getItem("sesion"));

        if (sesion) {
            redirigir(sesion.roles_id);
        } else {
            loguearse();
        }
    }

    function loguearse() {
        $('#btn-ingresar').click(function (e) {
            e.preventDefault();

            let usuario = $('#dato-user').val();
            let clave = $('#dato-clave').val();

            let json = {
                "login": {
                    "usuario": usuario,
                    "clave": clave
                }
            };

            if (validar(usuario, clave)) {
                ajax(json);
                console.log(json);
            } else {
                //console.log('error');
            }
        });
    }

    function ajax(data) {
        $.ajax({
            url: urlServidor + 'usuarios/login',
            data: "data=" + JSON.stringify(data),
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  });
                if (response.status) {
                    Toast.fire({
                        icon: 'success',
                        title: response.mensaje
                      })

                    let sesion = response.usuario;
                    
                    sessionStorage.setItem('sesion', JSON.stringify(sesion));
                    
                    redirigir(sesion.roles.id);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.mensaje
                      })
                }
            },
            error: function (xhr, status) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (xhr, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function validar(usuario, clave) {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
        if (usuario.length == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Ingrese Usuario'
              })
            return false;
        } else if (clave.length == 0) {    
            Toast.fire({
                icon: 'info',
                title: 'Ingrese su contraseña'
              })
            return false;
        } else {
            return true;
        }
    }

    function redirigir(rol) {
        switch (rol) {
            case 1:
                window.location = urlCliente + 'dashboard/estadistico';
                break;
            case 2:
                window.location = urlCliente + 'cita/nueva';
                break;
            case 3:
                window.location = urlCliente + 'horario/nuevo';
                break;
            case 4:
                window.location = urlCliente + 'administracion/nuevoProducto';
                break; 
            case 5:
                window.location = urlCliente + 'aplicacion/vacuna';
                break;
            default:
                window.location = urlCliente + 'inicio/administrador';
                break;
        }
    }

});