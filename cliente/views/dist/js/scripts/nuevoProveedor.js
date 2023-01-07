var tabla;
/* $(function(){ */

    _init();

    function _init(){
        cargarRuc();
        validarFormularioProveedor();
        guardarProveedor();
        listarProveedores();
        editandoProveedorModal();
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

    function cargarRuc(){
        $('#ruc-prov').blur(function(){
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

             let ruc = $('#ruc-prov').val();
 
             cedula = ruc.substring(0,10);
             extraruc = ruc.substring(10,13);
 
             if(validarRuc(cedula,extraruc)){
                Toast.fire({
                    icon: 'success',
                    title: 'El ruc valido'
                })
             }else{
                Toast.fire({
                    icon: 'warning',
                    title: 'El ruc es invalido'
                })
             }
         });
    }
 
    function validarRuc(cedula,extraruc){
        ced = validarcedula(cedula);
        bandera = false;

        if(extraruc==='001'){
            bandera = true;
        }else{
            bandera = false;
        }

        if(ced && bandera){
            return true;
        }else{
            return false;
        }
    }

    function validarFormularioProveedor() {
        $('#formulario-proveedor').validate({
            rules: {
                ruc: {
                    required: true,
                    maxlength: 13,
                    minlength: 13
                },
                nombre: {
                    required: true,
                    minlength: 2
                },
                telefono: {
                    required: true,
                    minlength: 10
                },
                correo: {
                    required: true,
                    email: true
                },
                direccion: {
                    required: true,
                },
            },
            messages: {
                ruc: {
                    required: "Ingrese una cédula",
                    maxlength: "La cédula debe tener 13 dígitos",
                    minlength: "Debe tener 13 digítos"
                },
                nombre: {
                    required: "Ingrese un nombre",
                    minlength: "Debe tener mínimo 2 carácteres"
                },
                telefono: {
                    required: "Ingrese un teléfono",
                    minlength: "Debe tener mínimo 10 dígitos"
                },
                correo: {
                    required: "Ingrese un correo",
                    email: "Correo no valido"
                },
                direccion: {
                    required: "Ingrese una descripción",
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

    function guardarProveedor(){
        $('#formulario-proveedor').submit(function(e){
           e.preventDefault();

           let nombre_proveedor = $('#nombre-prov').val();
           let ruc = $('#ruc-prov').val();
           let telefono = $('#telefono-prov').val();
           let direccion = $('#direccion-prov').val();
           let correo = $('#correo-prov').val();

           let json = {
                proveedor:{
                    nombre_proveedor: nombre_proveedor,
                    ruc: ruc,
                    telefono: telefono,
                    direccion: direccion,
                    correo: correo
                }
           };

           //validacion para datos de usuario
           if(!validarProveedor(json)){
               console.log('llene los datos de usuario');
           }else{
               guardandoproveedor(json);
           }
        });
    }

    function validarProveedor(json){
        let proveedor = json.proveedor;
        //expresion regular -> validar correo electronico
        var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if(proveedor.ruc.length==0){
            Toast.fire({
                icon: 'info',
                title: 'Ingrese un ruc'
            })
            return false;
        }else if(proveedor.nombre_proveedor.length==0){
            Toast.fire({
                icon: 'info',
                title: 'Ingrese el nombre del proveedor'
            })
            return false;
        }else if(proveedor.telefono.length==0){
            Toast.fire({
                icon: 'info',
                title: 'Ingrese un teléfono'
            })
            return false;
        }else if(proveedor.direccion==0){
            Toast.fire({
                icon: 'info',
                title: 'Ingrese una dirección'
            })
            return false;
        }else if(proveedor.correo.length==0){
            Toast.fire({
                icon: 'info',
                title: 'Ingrese un correo'
            })
            return false;
        }else if (caract.test(proveedor.correo)==false){
            Toast.fire({
                icon: 'info',
                title: 'Correo no Válido'
            })
            return false;
        }else {
            return true;
        }
    }

    function guardandoproveedor(json){
        $.ajax({
            url: urlServidor  + 'proveedores/guardar',
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
                    $('#formulario-proveedor')[0].reset();
                    listarProveedores();
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

    function listarProveedores() {
        tabla=$('#tabla-proveedores').dataTable({
            "lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [		          
                    ],
            "ajax":
                    {
                        url:  urlServidor + 'proveedores/listarDataTable', 
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

    function editandoProveedorModal(){
        $('#btn-update').click(function(){
    
            let id = $('#proveedor-id').val();
            let nombre_proveedor = $('#nombre-prov-upd').val();
            let ruc = $('#ruc-prov-upd').val();
            let telefono = $('#telefono-prov-upd').val();
            let direccion = $('#direccion-prov-upd').val();
            let correo = $('#correo-prov-upd').val();
                    
            let json = {
                proveedores:{
                    id: id,
                    nombre_proveedor: nombre_proveedor,
                    ruc: ruc,
                    telefono: telefono,
                    direccion: direccion,
                    correo: correo
                }
            };
    
            $.ajax({
                // la URL para la petición
                url : urlServidor + 'proveedores/editar',
                type : 'POST',
                data: {data: JSON.stringify(json)},
                dataType : 'json',
                success : function(response){
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
                        $('#modal-editar-proveedor').modal('hide');
                        listarProveedores();
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
/* }); */

function eliminarProveedor(id){
    let data = {
        proveedores: {
            id: id,
        }
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'proveedores/eliminar',
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
                    title: 'Se Ha eliminado el proveedor del sistema'
                })
            listarProveedores();
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

function editarProveedor(id){
    $('#modal-editar-proveedor').modal('show'); 
    cargarProveedor(id);  
}

function cargarProveedor(id){
    $.ajax({
        url:urlServidor  +'proveedores/listarxId/'+id,
        type:'GET',
        dataType:'json',
        success:function(response){
            console.log(response);
            if(response.status){    
                $('#proveedor-id').val(response.proveedor.id);
                $('#ruc-prov-upd').val(response.proveedor.ruc);
                $('#nombre-prov-upd').val(response.proveedor.nombre_proveedor);
                $('#telefono-prov-upd').val(response.proveedor.telefono);
                $('#direccion-prov-upd').val(response.proveedor.direccion);
                $('#correo-prov-upd').val(response.proveedor.correo);
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