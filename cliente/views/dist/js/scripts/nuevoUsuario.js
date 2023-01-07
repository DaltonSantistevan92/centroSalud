var tabla;
/* $(function(){ */

    _init();

    function _init(){
        cargarSexo();
        cargarCargo();
        validarFormularioUsuario();
        guardarUsuario();
        changecedula();
        listarUsuarios();
        listarUsuarioDoctor();
        listarUsuarioEnfermero();
        editandousuarioModal();
    }

    function cargarSexo(){
        $.ajax({
            url:urlServidor  +'sexo/listar',
            type:'GET',
            dataType:'json',
            success:function(response){
            //    console.log(response);
                if(response.status){
                   let option = '<option value="0">Seleccione Sexo</option>';
                   response.sexo.forEach(element=>{
                        option +=`<option value=${element.id}>${element.tipo}</option>`;
                   });
                   $('#new-sexo').html(option);
                   $('#upd-sexo').html(option);
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

    function cargarCargo(){
        $.ajax({
            url:urlServidor  +'roles/listar',
            type:'GET',
            dataType:'json',
            success:function(response){
                 if(response.status){
                   let option = '<option value="0">Seleccione Cargo</option>';
                   response.rol.forEach(element=>{
                        option +=`<option value=${element.id}>${element.cargo}</option>`;
                   });
                   $('#new-cargo').html(option);
                   $('#upd-cargo').html(option);
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

    function validarFormularioUsuario() {
        $('#form-datos-usuario').validate({
            rules: {
                cedula: {
                    required: true,
                    maxlength: 10,
                    minlength: 10
                },
                nombre: {
                    required: true,
                    minlength: 3
                },
                apellido: {
                    required: true,
                    minlength: 3
                },
                celular: {
                    required: true,
                    minlength: 10
                },
                usuario: {
                    required: true,
                    minlength: 3
                },
                correo: {
                    required: true,
                    email: true
                },
                clave: {
                    required: true,
                    minlength: 4
                },
                confclave: {
                    required: true,
                    minlength: 4
                },
            },
            messages: {
                cedula: {
                    required: "Ingrese una cédula",
                    maxlength: "La cédula debe tener 10 dígitos",
                    minlength: "Debe tener 10 digítos"
                },
                nombre: {
                    required: "Ingrese un nombre",
                    minlength: "Debe tener mínimo 3 carácteres"
                },
                apellido: {
                    required: "Ingrese un apellido",
                    minlength: "Debe tener mínimo 3 carácteres"
                },
                celular: {
                    required: "Ingrese un numero celular",
                    minlength: "Debe tener mínimo 10 dígitos"
                },
                correo: {
                    required: "Ingrese un correo",
                    email: "Correo no valido"
                },
                usuario: {
                    required: "Ingrese un usuario",
                    minlength: "Debe tener mínimo 3 carácteres"
                },
                clave: {
                    required: "Ingrese una contraseña",
                    minlength: "Debe tener mínimo 4 carácteres"
                },
                confclave: {
                    required: "Confirme la contraseña",
                    minlength: "Debe tener mínimo 4 carácteres"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    }

    function guardarUsuario(){
        $('#form-datos-usuario').submit(function(e){
           e.preventDefault();

           let cedula = $('#new-cedula').val();
           let nombre=  $('#new-nombre').val();
           let apellido= $('#new-apellido').val();
           let num_celular= $('#new-celular').val();
           let direccion= $('#new-direccion').val();   
           let sexo_id = $('#new-sexo option:selected').val();
           let roles_id = $('#new-cargo option:selected').val();
           let usuario= $('#new-usuario').val();  
           let correo= $('#new-correo').val();   
           let clave= $('#new-clave').val();   
           let conf_clave= $('#new-confclave').val();   
           let foto= $('#new-foto-usuario')[0].files[0]; 
           let def = (foto == undefined) ? 'user_default.png' : foto.name;

           let json = {
               usuario:{
                   roles_id,
                   usuario,
                   correo,
                   clave,
                   conf_clave,
                   foto:def
               },
               persona:{
                   cedula,
                   nombre,
                   apellido,
                   num_celular,
                   direccion,
                   sexo_id      
               },
               doctor:{

               },
               enfermero:{

               }
           };

           //validacion para datos de usuario
           if(!validarPersona(json)){
               console.log('llene los datos de usuario');
           }else{
               guardandousuario(json);
           }
        });
    }

    function validarPersona(json){
        let persona = json.persona;
        let usuario = json.usuario;
        //expresion regular -> validar correo electronico
        var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if(persona.cedula.length==0){
            return false;
        }else if(persona.nombre.length==0){
            return false;
        }else if(persona.apellido.length==0){
            return false;
        }else if(persona.sexo_id==0){
            Toast.fire({
                icon: 'error',
                title: 'Seleccione el sexo'
            })
            return false;
        }else if(usuario.correo.length==0){
            Toast.fire({
                icon: 'error',
                title: 'Ingrese un correo'
            })
            return false;
        }else if(persona.cedula.length<10 || persona.nombre.length <2 || persona.apellido.length <2){
            return false;
        }else if (caract.test(usuario.correo)==false){
            Toast.fire({
                icon: 'error',
                title: 'Correo no Valido'
            })
            return false;
        }else if (persona.length==0){
            return false;
        }else if(usuario.roles_id==0){
            Toast.fire({
                icon: 'error',
                title: 'Seleccione el cargo'
            })
            return false;
        }else if(usuario.clave.length==0){
            return false;
        }else if (usuario.conf_clave.length==0){
            return false;
        }else if (usuario.clave !== usuario.conf_clave){ 
            Toast.fire({
                icon: 'error',
                title: 'Las contraseña no coinciden'
            })
            return false;
        }
        else if (!validarcedula(persona.cedula)){
            Toast.fire({
                icon: 'error',
                title: 'La cedula es incorrecta'
            })
            return false; 
        }else {
            return true;
        }
    }

   function guardandousuario(json){
       $.ajax({
           url:urlServidor  +'usuarios/guardarUsuario',
           type:'POST',
           data: 'data=' + JSON.stringify(json),
           dataType:'json',
           success:function(response){
           //    console.log(response);               
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

               if(response.status){
                   Toast.fire({
                    icon: 'success',
                    title: response.mensaje
                  })
                   $('#form-datos-usuario')[0].reset();
                   listarUsuarios();
                   listarUsuarioDoctor();
                   listarUsuarioEnfermero();
               } else{
                Toast.fire({
                    icon: 'error',
                    title: response.mensaje
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

       if(json.usuario.foto=='user_default.png'){

       }else{
           let imagen=$('#new-foto-usuario')[0].files[0];
           let formData= new FormData();
           formData.append('fichero',imagen);

           $.ajax({
               // la URL para la petición
               url : urlServidor + 'usuarios/subirFoto',
               // especifica si será una petición POST o GET
               type : 'POST',
               // el tipo de información que se espera de respuesta
               data: formData,
               contentType: false,
               processData: false,
               dataType : 'json',
               success : function(responseImg) {
                   if(responseImg.status){
                     
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
   }

    function validarcedula(cedula){
        if(cedula.length == 10){
        
            //Obtenemos el digito de la region que sonlos dos primeros digitos
            var digito_region = cedula.substring(0,2);
            
            //Pregunto si la region existe ecuador se divide en 24 regiones
            if( digito_region >= 1 && digito_region <=24 ){
              
              // Extraigo el ultimo digito
              var ultimo_digito   = cedula.substring(9,10);
    
              //Agrupo todos los pares y los sumo
              var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));
    
              //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
              var numero1 = cedula.substring(0,1);
              var numero1 = (numero1 * 2);
              if( numero1 > 9 ){ var numero1 = (numero1 - 9); }
    
              var numero3 = cedula.substring(2,3);
              var numero3 = (numero3 * 2);
              if( numero3 > 9 ){ var numero3 = (numero3 - 9); }
    
              var numero5 = cedula.substring(4,5);
              var numero5 = (numero5 * 2);
              if( numero5 > 9 ){ var numero5 = (numero5 - 9); }
    
              var numero7 = cedula.substring(6,7);
              var numero7 = (numero7 * 2);
              if( numero7 > 9 ){ var numero7 = (numero7 - 9); }
    
              var numero9 = cedula.substring(8,9);
              var numero9 = (numero9 * 2);
              if( numero9 > 9 ){ var numero9 = (numero9 - 9); }
    
              var impares = numero1 + numero3 + numero5 + numero7 + numero9;
    
              //Suma total
              var suma_total = (pares + impares);
    
              //extraemos el primero digito
              var primer_digito_suma = String(suma_total).substring(0,1);
    
              //Obtenemos la decena inmediata
              var decena = (parseInt(primer_digito_suma) + 1)  * 10;
    
              //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
              var digito_validador = decena - suma_total;
    
              //Si el digito validador es = a 10 toma el valor de 0
              if(digito_validador == 10)
                var digito_validador = 0;
    
              //Validamos que el digito validador sea igual al de la cedula
              if(digito_validador == ultimo_digito){
                return true;
              }else{
                return false;
              }
              
            }else{
              // imprimimos en consola si la region no pertenece
              return false;
            }
         }else{
            //imprimimos en consola si la cedula tiene mas o menos de 10 digitos
            return false;
         }    
          
    }

    function changecedula(){
        $('#new-cedula').blur(function(){
            let cedula = $('#new-cedula').val();

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });

            if(!validarcedula(cedula)){
                Toast.fire({
                    icon: 'warning',
                    title: 'La cédula es invalida'
                  })
            }else{
                Toast.fire({
                    icon: 'success',
                    title: 'La cédula es valida'
                  })
            } 
        });
    }

    function listarUsuarios() {
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'usuarios/card', 
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                let div = '';
                if (response.length > 0) {
                    response.forEach(e => {
                        let i = 0;
                        div += `
                        <div class="col-12 col-sm-6 col-md-4 d-flex">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-body pt-1">
                                    <div class="row">
                                    <div class="col-12">
                                        <h2 class="lead text-primary text-center"><b>${e.usuario.personas.nombre} ${e.usuario.personas.apellido}</b></h2>
                                        <p class="text-muted text-sm text-center">
                                            <i class="fa-solid fa-envelope-circle-check"></i>
                                            <b>Correo: </b> ${e.usuario.correo}
                                        </p>
                                    </div>
                                        <div class="col-8">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="far fa-address-card"></i>
                                                    </span> <b>Cargo:</b>  ${e.usuario.roles.cargo}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-user"></i>
                                                    </span> <b>Usuario:</b>  ${e.usuario.usuario}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-c"></i>
                                                    </span> <b>Cedula:</b> ${e.usuario.personas.cedula}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-mobile-screen"></i>
                                                    </span> <b>Celular #:</b> ${e.usuario.personas.num_celular}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-venus-mars"></i>
                                                    </span> <b>Sexo:</b> ${e.usuario.personas.sexo.tipo}
                                                </li>  
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-building-flag"></i>
                                                    </span> <b>Direccion:</b> ${e.usuario.personas.direccion}
                                                </li>     
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center">
                                            <img src="${urlServidor}resources/usuarios/${e.usuario.foto}" alt="user-avatar"
                                                class="img-circle img-fluid box-img-usuario" style="margin-top: 10px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <button data-dismiss="modal" class="btn btn-outline-primary btn-sm" onclick="editarUsuario(${e.usuario_id})">
                                        <i class="fa-solid fa-pen-to-square mr-2"></i>
                                            Editar
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="eliminarUsuario(${e.usuario_id})">
                                        <i class="fa-solid fa-xmark mr-2"></i>
                                            Eliminar
                                        </button>

                                      
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        i++;
                    });
                }else if(response.status == false){
                    div += `<div class="col-12">
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> ${response.mensaje}</h5>
                        </div>
                    </div>`;
                }
                $('#listar-usuario').html(div);
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function listarUsuarioDoctor() {
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'usuarios/cardDoctor', 
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                let div = '';
                if (response.length > 0) {
                    response.forEach(e => {
                        let i = 0;
                        div += `
                        <div class="col-12 col-sm-6 col-md-4 d-flex">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-body pt-1">
                                    <div class="row">
                                    <div class="col-12">
                                        <h2 class="lead text-primary text-center"><b>${e.usuario.personas.nombre} ${e.usuario.personas.apellido}</b></h2>
                                        <p class="text-muted text-sm text-center">
                                            <i class="fa-solid fa-envelope-circle-check"></i>
                                            <b>Correo: </b> ${e.usuario.correo}
                                        </p>
                                    </div>
                                        <div class="col-8">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="far fa-address-card"></i>
                                                    </span> <b>Cargo:</b>  ${e.usuario.roles.cargo}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-user"></i>
                                                    </span> <b>Usuario:</b>  ${e.usuario.usuario}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-c"></i>
                                                    </span> <b>Cedula:</b> ${e.usuario.personas.cedula}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-mobile-screen"></i>
                                                    </span> <b>Celular #:</b> ${e.usuario.personas.num_celular}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-venus-mars"></i>
                                                    </span> <b>Sexo:</b> ${e.usuario.personas.sexo.tipo}
                                                </li>  
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-building-flag"></i>
                                                    </span> <b>Direccion:</b> ${e.usuario.personas.direccion}
                                                </li>     
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center">
                                            <img src="${urlServidor}resources/usuarios/${e.usuario.foto}" alt="user-avatar"
                                                class="img-circle img-fluid box-img-usuario" style="margin-top: 10px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <button data-dismiss="modal" class="btn btn-outline-primary btn-sm" onclick="editarUsuario(${e.usuario_id})">
                                        <i class="fa-solid fa-pen-to-square mr-2"></i>
                                            Editar
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="eliminarUsuarioDoctor(${e.usuario_id})">
                                        <i class="fa-solid fa-xmark mr-2"></i>
                                            Eliminar
                                        </button>

                                      
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        i++;
                    });
                }else if(response.status == false){
                    div += `<div class="col-12">
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> ${response.mensaje}</h5>
                        </div>
                    </div>`;
                }
                $('#listar-usuario-doctor').html(div);
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function listarUsuarioEnfermero() {
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'usuarios/cardEnfermero', 
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                let div = '';
                if (response.length > 0) {
                    response.forEach(e => {
                        let i = 0;
                        div += `
                        <div class="col-12 col-sm-6 col-md-4 d-flex">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-body pt-1">
                                    <div class="row">
                                    <div class="col-12">
                                        <h2 class="lead text-primary text-center"><b>${e.usuario.personas.nombre} ${e.usuario.personas.apellido}</b></h2>
                                        <p class="text-muted text-sm text-center">
                                            <i class="fa-solid fa-envelope-circle-check"></i>
                                            <b>Correo: </b> ${e.usuario.correo}
                                        </p>
                                    </div>
                                        <div class="col-8">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="far fa-address-card"></i>
                                                    </span> <b>Cargo:</b>  ${e.usuario.roles.cargo}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-user"></i>
                                                    </span> <b>Usuario:</b>  ${e.usuario.usuario}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-c"></i>
                                                    </span> <b>Cedula:</b> ${e.usuario.personas.cedula}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-mobile-screen"></i>
                                                    </span> <b>Celular #:</b> ${e.usuario.personas.num_celular}
                                                </li>
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-venus-mars"></i>
                                                    </span> <b>Sexo:</b> ${e.usuario.personas.sexo.tipo}
                                                </li>  
                                                <li class="small">
                                                    <span class="fa-li">
                                                        <i class="fa-solid fa-building-flag"></i>
                                                    </span> <b>Direccion:</b> ${e.usuario.personas.direccion}
                                                </li>     
                                            </ul>
                                        </div>
                                        <div class="col-4 text-center">
                                            <img src="${urlServidor}resources/usuarios/${e.usuario.foto}" alt="user-avatar"
                                                class="img-circle img-fluid box-img-usuario" style="margin-top: 10px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <button data-dismiss="modal" class="btn btn-outline-primary btn-sm" onclick="editarUsuario(${e.usuario_id})">
                                        <i class="fa-solid fa-pen-to-square mr-2"></i>
                                            Editar
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="eliminarUsuarioEnfermero(${e.usuario_id})">
                                        <i class="fa-solid fa-xmark mr-2"></i>
                                            Eliminar
                                        </button>

                                      
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        i++;
                    });
                }else if(response.status == false){
                    div += `<div class="col-12">
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> ${response.mensaje}</h5>
                        </div>
                    </div>`;
                }
                $('#listar-usuario-enfermero').html(div);
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }
    
/* }); */

function eliminarUsuario(id){
    let data = {
        usuario: {
            id: id,
        }
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'usuarios/eliminar',
        // especifica si será una petición POST o GET
        type : 'POST',
        // el tipo de información que se espera de respuesta
        data: {data: JSON.stringify(data)},
        dataType : 'json',
        success : function(response) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });

            if(response.status){
                Toast.fire({
                    icon: 'success',
                    title: 'Se Ha eliminado el usuario del sistema'
                  })
                  listarUsuarios();
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

function eliminarUsuarioDoctor(id){
    let data = {
        usuario: {
            id: id,
        }
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'usuarios/eliminar',
        // especifica si será una petición POST o GET
        type : 'POST',
        // el tipo de información que se espera de respuesta
        data: {data: JSON.stringify(data)},
        dataType : 'json',
        success : function(response) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });

            if(response.status){
                Toast.fire({
                    icon: 'success',
                    title: 'Se Ha eliminado el usuario del sistema'
                  })
                  listarUsuarioDoctor();
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

function eliminarUsuarioEnfermero(id){
    let data = {
        usuario: {
            id: id,
        }
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'usuarios/eliminar',
        // especifica si será una petición POST o GET
        type : 'POST',
        // el tipo de información que se espera de respuesta
        data: {data: JSON.stringify(data)},
        dataType : 'json',
        success : function(response) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });

            if(response.status){
                Toast.fire({
                    icon: 'success',
                    title: 'Se Ha eliminado el enfermero del sistema'
                  })
                  listarUsuarioEnfermero();
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

function editarUsuario(id){
    $('#modal-editar-usuario').modal('show'); 
    cargarUsuario(id);  
}

function cargarUsuario(id){
    $.ajax({
        url:urlServidor  +'usuarios/listar/'+id,
        type:'GET',
        dataType:'json',
        success:function(response){
            console.log(response);
            if(response.status){    
                $('#usuario-id').val(response.usuario.id);//usuario_id
                $('#persona-id').val(response.usuario.personas.id);//persona_id
                $('#upd-cargo').val(response.usuario.roles.id);//rol_id
                $('#upd-usuario').val(response.usuario.usuario);//nombre_usuario
                $('#upd-correo').val(response.usuario.correo);//correo_usuario
                $('#upd-cedula').val(response.usuario.personas.cedula);
                $('#upd-nombre').val(response.usuario.personas.nombre);
                $('#upd-apellido').val(response.usuario.personas.apellido);
                $('#upd-celular').val(response.usuario.personas.num_celular);
                $('#upd-direccion').val(response.usuario.personas.direccion);
                $('#upd-sexo').val(response.usuario.personas.sexo_id);//sexo_id
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

function editandousuarioModal(){
    $('#btn-update').click(function(){

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        }); 

        let id = $('#usuario-id').val();
        let personas_id = $('#persona-id').val();
        let roles_id = $('#upd-cargo option:selected').val();
        let usuario =  $('#upd-usuario').val();
        let correo = $('#upd-correo').val();
        let nombre =$('#upd-nombre').val();
        let apellido =$('#upd-apellido').val();
        let num_celular  =$('#upd-celular').val();
        let direccion = $('#upd-direccion').val();
        let sexo_id = $('#upd-sexo option:selected').val();

        //expresion regular -> validar correo electronico
        var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

        if (caract.test(correo)==false){
            Toast.fire({
                icon: 'error',
                title: 'Correo no es Válido'
            })
        } else {
            let json = {
                usuario: {
                    id:id,
                    personas_id: personas_id,
                    roles_id: roles_id,
                    usuario:usuario,
                    correo:correo,
                    nombre: nombre,
                    apellido: apellido,
                    num_celular:num_celular,
                    direccion:direccion,
                    sexo_id:sexo_id,
                }
            };

            $.ajax({
                // la URL para la petición
                url : urlServidor + 'usuarios/editarUsuario',
                type : 'POST',
                data: {data: JSON.stringify(json)},
                dataType : 'json',
                success : function(response){
                    /*  console.log(response); */
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                      });    
    
                    if(response.status){
                        Toast.fire({
                            icon: 'success',
                            title: response.mensaje
                          })
                        $('#modal-editar-usuario').modal('hide');
                        listarUsuarios();
                        listarUsuarioDoctor();
                        listarUsuarioEnfermero();
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: response.mensaje
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
    });
}