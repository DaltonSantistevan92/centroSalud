var tabla;
/* $(function(){ */
    var valor = false;
    var valor2 = false;

    _init();

    function _init(){
        guardarCategoria();
        cargarCategorias();
        generarCodigo();
        disponibilidad();
        guardarProducto();
        cargarTablaProductos();
        editandoProductoModal();
        disponibilidadEditar();
    }

    function guardarCategoria(){
        $('#nueva-categoria').click(function(){
            let categoria = $('#texto-categoria').val();

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            if(categoria.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Ingrese el nombre de una categoria'
                  })
            }else{
                let json ={
                    categoria:{
                        categoria,
                    }
                }
                guardandocategoria(json);
            }       
        });
    }

    function guardandocategoria(json){
        $.ajax({
            url:urlServidor  +'categorias/guardar',
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
                    $('#texto-categoria').val('');
                    //cargarTabla();
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

    function cargarCategorias() {
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'categorias/listar',
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let option = '<option value=0>Seleccione Categoria</option>';

                    response.categoria.forEach(element => {
                        option += `<option value=${element.id}>${element.categoria}</option>`;
                    });
                    $('#select-categoria').html(option);
                    $('#upd-select-categoria').html(option);
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (jqXHR, status) {
                // console.log('Petición realizada');
            }
        });

    }

    function generarCodigo(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'productos/mostrarCodigo/productos',
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
               if(response.status){
                   $('#codigo-producto').val(response.codigo);
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
    
    function guardarCodigo(){
        let codigo = $('#codigo-producto').val();
    
        let json = {
            codigo: {
                codigo: codigo,
                tipo: 'productos'
            }
        }
    
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'productos/guardarCodigo',
            // especifica si será una petición POST o GET
            type : 'POST',
            data : "data=" + JSON.stringify(json),
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                //console.log(response); 
                generarCodigo();
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function guardarProducto(){
        $('#form-datos-productos').submit(function(e){
            e.preventDefault();

            let categorias_id = $('#select-categoria option:selected').val();
            let nombre =  $('#nombre-producto').val();
            let imagen = $('#imagen-producto')[0].files[0]; 
            let descripcion = $('#descripcion-producto').val();
            let codigo = $('#codigo-producto').val();
            let def = (imagen == undefined) ? 'producto_default.jpg' : imagen.name;

            let json = {
                producto:{
                    categorias_id,
                    codigo,
                    nombre,
                    imagen:def,
                    descripcion,   
                    d_campania : valor
                },
            };

            console.log(json);

            //validacion para datos de usuario
            if(!validarProducto(json)){
                console.log('llene los datos de usuario');
            }else{
                guardandoProducto(json);  
            } 

        });
    }

    function disponibilidad(){       
        $('#d_campania').change(function(){
            valor = $('#d_campania').prop('checked');
        });
    }

    function validarProducto(json){
        let producto = json.producto;

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if(producto.categorias_id == 0){
            Toast.fire({
                icon: 'info',
                title: 'Seleccione una categoría'
            })
            return false;
        }else if(producto.nombre.length == 0){
            Toast.fire({
                icon: 'info',
                title: 'Ingrese un nombre'
            })
            return false;
        }else {
            return true;
        }
    }

    function guardandoProducto(json){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'productos/guardar',
            data : "data=" + JSON.stringify(json),
            // especifica si será una petición POST o GET
            type : 'POST',
            // el tipo de información que se espera de respuesta
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
                        title: response.mensaje
                    })
                    guardarCodigo();
                    $('#form-datos-productos')[0].reset();
                    cargarTablaProductos();   
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

        if(json.producto.imagen == 'producto_default.jpg'){

        }else{
            let foto = $('#imagen-producto')[0].files[0];
            let formdata = new FormData();
            formdata.append('fichero',foto); 

            $.ajax({
                // la URL para la petición
                url : urlServidor + 'productos/subirFotoProducto',
                data : formdata,
                contentType: false,
                processData: false, 
                // especifica si será una petición POST o GET
                type : 'POST',
                // el tipo de información que se espera de respuesta
                dataType : 'json',
                success : function(response) {
                    //console.log(response);
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

    function cargarTablaProductos(){
        tabla = $('#tabla-productos').DataTable({
            "lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            "ajax":
                {
                    url:  urlServidor + 'productos/listarProductosDataTable',
                    type : "get",
                    dataType : "json",						
                    error: function(e){
                        console.log(e.responseText);	
                    }
                },
            destroy: true,
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
                },
    
            }//cerrando language
        });
    }

    function editandoProductoModal(){
        $('#btn-update').click(function(){
    
            let id = $('#producto-id').val();
            let categorias_id = $('#upd-select-categoria option:selected').val();
            let nombre =  $('#upd-nombre-producto').val();
            let descripcion = $('#upd-descripcion-producto').val();
                    
            let json = {
                producto:{
                    id,
                    categorias_id,
                    nombre,
                    descripcion,   
                    d_campania : valor2
                },
            };
            
            $.ajax({
                // la URL para la petición
                url : urlServidor + 'productos/editarProducto',
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
                        $('#modal-editar-producto').modal('hide');
                    cargarTablaProductos();
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

function eliminarProducto(id){
    let data = {
        producto: {
            id: id,
        }
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'productos/eliminarProductos',
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
                    title: response.mensaje
                })
                cargarTablaProductos();
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

function editarProducto(id){
    $('#modal-editar-producto').modal('show'); 
    cargarProducto(id);  
}

function cargarProducto(id){
    $.ajax({
        url:urlServidor  +'productos/listarxId/'+id,
        type:'GET',
        dataType:'json',
        success:function(response){
            console.log(response);
            if(response.status){    
                $('#producto-id').val(response.producto.id);
                $('#upd-codigo-producto').val(response.producto.codigo);
                $('#upd-nombre-producto').val(response.producto.nombre);
                $('#upd-select-categoria').val(response.producto.categorias.id);
                $('#upd-stock-producto').val(response.producto.stock);
                $('#upd-descripcion-producto').val(response.producto.descripcion);
                $('#d_campania_e').prop('checked', response.producto.d_campania);
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

function disponibilidadEditar(){       
    $('#d_campania_e').change(function(){
        valor2 = $('#d_campania_e').prop('checked');
    });
}
