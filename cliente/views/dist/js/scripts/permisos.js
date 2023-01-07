$(function(){

    _init();

    function _init(){
        cargarCargos();
        cargarMenus();
        getPermisos();
    }

    function cargarCargos(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'roles/listar',
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                if(response.status){
                    let option = '<option value=0>Seleccione Cargo</option>';
                    
                    response.rol.forEach(element =>{
                        option += `<option value=${element.id}>${element.cargo}</option>`;
                    });
                    $('#select-cargo').html(option);
   
                }else{
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                      });
                      Toast.fire({
                        icon: 'error',
                        title: 'No hay roles disponibles'
                      })
                }               
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function cargarMenus(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'permisos/listarPermiso',
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                //console.log(response); 
                $('#body-menus').html('');

                if(response.length > 0){
                    let tr = '';  let fila = '';
                    let inicio = ''; let fin = '';

                    for (let i = 0; i < response.length; i++) {
                        const element = response[i];
                        inicio = `<tr>`;

                        tr = ` <td class="border check-permiso" data-id="${element.padre.id}">
                        <div class="custom-control custom-checkbox" data-id="${element.padre.id}">
                            <input class="custom-control-input" type="checkbox" id="permiso-item-${element.padre.id}" data-id="${element.padre.id}"
                                value="option1" onChange="marcar_permiso(${element.padre.id})">
                            <label for="permiso-item-${element.padre.id}" class="custom-control-label">${element.padre.menu}</label>
                        </div>
                    </td>`;
                        for (let j = 0; j < element.hijos.length; j++) {
                            const item = element.hijos[j];
                            //console.log(item);
                            tr += `<td class="border check-permiso" data-id="${item.id}">
                            <div class="form-check" data-id="${item.id}">
                                <input class="form-check-input" type="checkbox" id="permiso-item-${item.id}" data-id="${item.id}" onChange="marcar_permiso(${item.id})">
                                <label for="permiso-item-${item.id}" class="form-check-label">${item.menu}</label>
                            </div>
                        </td>`; 
                        }
                       
                        fin = `</tr>`;
                        fila = inicio + tr + fin;
                        $('#body-menus').append(fila);
                    }
                    //$('#body-menus').html(fila);
                }          
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function getPermisos(){
        $('#select-cargo').change(function(){
            let id = $('#select-cargo').val();
            if(id == '0'){
                clear_check();
            }else{
                ajax_rol_permiso(id);
            }
        })
    }

    function ajax_rol_permiso(id){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'permisos/mostrarPermisoRol/' + id,
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                console.log(response);
                let array = document.querySelectorAll('.check-permiso div input');  //38 nodos
                clear_check();
                response.forEach(element => {
                    array.forEach(nodo => {
                        let nodo_id = parseInt(nodo.getAttribute('data-id'));
                        let id = nodo.getAttribute('id');
    
                        if(element.menus_id === nodo_id){
                            $('#' + id).prop('checked',true);
                            nodo.setAttribute('data-permiso', element.id);
                        }
                    });           
                });
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function  clear_check(){
        let array = document.querySelectorAll('.check-permiso div input');  //38 nodos

        array.forEach(element => {
            let id = element.getAttribute('id');
            $('#' + id).prop('checked',false);
        });
    }
});

function marcar_permiso(id){
    //alert(id);
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    let combo_id = $('#select-cargo option:selected').val();

    if(combo_id == '0'){
          Toast.fire({
            icon: 'info',
            title: 'Debe seleccionar un cargo'
          })
    }else{
       
        let nodo = document.getElementById('permiso-item-' + id);
        let permisos_id = nodo.getAttribute('data-permiso');

        if(nodo.checked){
            //console.log('check activado');
            ajax_permiso(id,'S',permisos_id,combo_id);
        }else{
            //console.log('check desactivado');
            ajax_permiso(id,'N',permisos_id,combo_id);
            ajax_rol_permiso(combo_id);
        }
    }
}

function ajax_permiso(menus_id,permiso,permisos_id,roles_id){
    let json = {
        permiso: {menus_id, permiso, permisos_id, roles_id}
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'permisos/otorgarPermiso',
        // especifica si será una petición POST o GET
        type : 'POST',
        data : "data=" + JSON.stringify(json),
        // el tipo de información que se espera de respuesta
        dataType : 'json',
        success : function(response) {
           var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          Toast.fire({
            icon: 'success',
            title: response.mensaje
          })
        },
        error : function(jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete : function(jqXHR, status) {
            // console.log('Petición realizada');
        }
    });

}