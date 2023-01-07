/* $(function(){ */

init();

function init() {
  datos();
  cargarMenu();
  logout();
}

function getSesion() {
  let sesion = JSON.parse(sessionStorage.getItem('sesion'));

  if (sesion) {
    return sesion;
  } else {
    return null;
  }
}

function cargarMenu() {
  let sesion = JSON.parse(sessionStorage.getItem('sesion'));

  if (sesion) {
    let rol_id = sesion.roles.id;

    $.ajax({
      url: urlServidor + 'permisos/rol/' + rol_id,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
       if(response){
          let hijos = "";
          let menu = ''; let i = 0; 
          response.forEach(element => { 
              
            //recorre menus hijos
            let hijos = "";
            element.menus_hijos.forEach(hijo => {
              hijos += 
              `<li class="nav-item">
                <a href="${urlCliente}${hijo.url}" class="nav-link">
                  <i class="fa-solid fa-caret-right mr-2"></i>
                  <p>${hijo.nombre}</p>
                </a>
              </li>`;
            });

            if(i == 0){
              menu += `
              <li class="nav-item">
                <a class="nav-link active">
                  <i class="${element.icono} mr-2"></i>
                  <p>
                   ${element.nombre}
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  ${hijos}
                </ul>
              </li>
              `;
            }else{
              menu += `
              <li class="nav-item">
                <a class="nav-link">
                  <i class="${element.icono} mr-2"></i>
                  <p>
                   ${element.nombre}
                   <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  ${hijos}
                </ul>
              </li>
              `;
            }
            i++;
          });

        $('#menus-padres').html(menu);
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
}

function datos() {
  let sesion = getSesion();

  if (sesion) {
    let nombres = sesion.persona.nombre + ' ' + sesion.persona.apellido;
    let fotos = sesion.foto;
    let img = `<img src="${urlServidor}resources/usuarios/${fotos}" class="img-circle elevation-2" alt="User Image">`;
    let rol = sesion.roles.cargo;

    $('#sesion-usuario').html(nombres);
    $('#sesion-usuario2').html(nombres);
    $('#sesion-img').html(img);
    $('#sesion-rol').html(rol);
  }
}

function logout() {
  $('#sesion-logout').click(function () {
    Swal.fire({
      title: '¿Esta seguro de salir del sistema?',
      text: "Esperamos que vuelva!",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, estoy seguro',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'Centro de Salud',
          'Sesión Finalizada.',
          'success'
        )
        sessionStorage.clear();
        window.location = urlCliente + 'login';
      }
    })
    
  });
}

/* }); */


