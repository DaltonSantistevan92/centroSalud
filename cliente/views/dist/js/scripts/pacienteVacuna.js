var tabla;
/* $(function(){ */

    _init();

    function _init(){
        cargarSexo();
        validarFormularioPaciente();
        guardarPaciente();
        changecedula();
        listarPacientes();
        editandoPacienteModal();
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

    function validarFormularioPaciente() {
        $('#form-datos-paciente').validate({
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
                sexo: {
                    required: true,
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
                sexo: "Seleccione un sexo",
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

    function guardarPaciente(){
        $('#form-datos-paciente').submit(function(e){
           e.preventDefault();

           let cedula = $('#new-cedula').val();
           let nombre=  $('#new-nombre').val();
           let apellido= $('#new-apellido').val();
           let num_celular= $('#new-celular').val();
           let direccion= $('#new-direccion').val();   
           let sexo_id = $('#new-sexo option:selected').val();

           let json = {
               persona:{
                   cedula,
                   nombre,
                   apellido,
                   num_celular,
                   direccion,
                   sexo_id      
               },
           };

           //validacion para datos de usuario
           if(!validarPaciente(json)){
               console.log('llene los datos de usuario');
           }else{
               guardandopaciente(json);
           }
        });
    }

    function validarPaciente(json){
        let persona = json.persona;

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
        }else if(persona.cedula.length<10 || persona.nombre.length <2 || persona.apellido.length <2){
            return false;
        }else if (persona.length==0){
            return false;
        }else if (!validarcedula(persona.cedula)){
            Toast.fire({
                icon: 'error',
                title: 'La cedula es incorrecta'
            })
            return false; 
        }else {
            return true;
        }
    }

   function guardandopaciente(json){
       $.ajax({
           url:urlServidor  +'pacientes/guardar',
           type:'POST',
           data: 'data=' + JSON.stringify(json),
           dataType:'json',
           success:function(response){              
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
                   $('#form-datos-paciente')[0].reset();
                   listarPacientes();
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

    function listarPacientes() {
        tabla=$('#tabla-pacientes').dataTable({
            "lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [		          
                    ],
            "ajax":
                    {
                        url:  urlServidor + 'pacientes/listarPacientesDataTable', 
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
    
            "language": {
    
                "sProcessing":     "Procesando...",
             
                "sLengthMenu":     "Mostrar _MENU_ registros",
             
                "sZeroRecords":    "No se encontraron resultados",
             
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
             
                "sInfo":           "Mostrando un total de _TOTAL_ registros",
             
                "sInfoEmpty":      "Mostrando un total de 0 registros",
             
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
             
                "sInfoPostFix":    "",
             
                "sSearch":         "Buscar:",
             
                "sUrl":            "",
             
                "sInfoThousands":  ",",
             
                "sLoadingRecords": "Cargando...",
             
                "oPaginate": {
             
                    "sFirst":    "Primero",
             
                    "sLast":     "Último",
             
                    "sNext":     "Siguiente",
             
                    "sPrevious": "Anterior"
             
                },
             
                "oAria": {
             
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
             
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
             
                }
    
               }//cerrando language
        });
    }
    
/* }); */

function eliminarPaciente(id){
    let data = {
        pacientes: {
            id: id,
        }
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'pacientes/eliminar',
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
                    title: 'Se Ha eliminado el paciente del sistema'
                })
            listarPacientes();
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

function editarPaciente(id){
    $('#modal-editar-paciente').modal('show'); 
    cargarPaciente(id);  
}

function cargarPaciente(id){
    $.ajax({
        url:urlServidor  +'pacientes/listarPacientesxId/'+id,
        type:'GET',
        dataType:'json',
        success:function(response){
            console.log(response);
            if(response.status){    
                $('#paciente-id').val(response.paciente.id);
                $('#persona-id').val(response.paciente.personas.id);
                $('#upd-cedula').val(response.paciente.personas.cedula);
                $('#upd-nombre').val(response.paciente.personas.nombre);
                $('#upd-apellido').val(response.paciente.personas.apellido);
                $('#upd-celular').val(response.paciente.personas.num_celular);
                $('#upd-direccion').val(response.paciente.personas.direccion);
                $('#upd-sexo').val(response.paciente.personas.sexo_id);
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

function editandoPacienteModal(){
    $('#btn-update').click(function(){

        let id = $('#paciente-id').val();
        let personas_id = $('#persona-id').val();
        let nombre =$('#upd-nombre').val();
        let apellido =$('#upd-apellido').val();
        let num_celular  =$('#upd-celular').val();
        let direccion = $('#upd-direccion').val();
        let sexo_id = $('#upd-sexo option:selected').val();
                
        let json = {
            pacientes: {
                id:id,
                personas_id: personas_id,
                nombre: nombre,
                apellido: apellido,
                num_celular:num_celular,
                direccion:direccion,
                sexo_id:sexo_id,
            }
        };

        $.ajax({
            // la URL para la petición
            url : urlServidor + 'pacientes/editar',
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
                    $('#modal-editar-paciente').modal('hide');
                    listarPacientes();
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
    });
}