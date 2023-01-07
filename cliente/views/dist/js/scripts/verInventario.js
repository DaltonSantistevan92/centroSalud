var tabla;
/* $(function(){ */

    _init();

    function _init(){
        cargarCategorias();
        cargarProductos();
        cargarInventario();
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
                    //$('#upd-categoria-p').html(option);
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

    function cargarProductos() {
        $('#select-categoria').change(function () {
            let id = $('#select-categoria option:selected').val();
            $.ajax({
                // la URL para la petición
                url: urlServidor + 'categorias/listarXidInventario/' + id,
                // especifica si será una petición POST o GET
                type: 'GET',
                // el tipo de información que se espera de respuesta
                dataType: 'json',
                success: function (response) {
                    //console.log(response);
                    let inicio = '<option value=0>Seleccione un Producto</option>';
                    let aux = 0;

                    if (response.status) {
                        response.categoria.productos.forEach(element => {
                            aux += `<option value='${element.id}'>${element.nombre}</option>`;
                        });
                        inicio += aux;
                    }
                    $('#select-productos').html(inicio);
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        });
    }

    function cargarInventario() {
        $('#btn-consultar').click(function () {
            let categoria_id = $('#select-categoria option:selected').val();
            let producto_id = $('#select-productos option:selected').val();

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            if(categoria_id == 0) {
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione una Categoría'
                })
            }else if(producto_id == 0) {
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione un Producto'
                })      
            }else{
                cargarTablaInventario(producto_id);
            }
        });
    }

    function cargarTablaInventario(id_producto) {
        tabla = $('#tabla-inventario').dataTable({
            "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [],
            "ajax":
            {
                url: urlServidor + 'inventario/verInventario/' + id_producto,
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }//cerrando language
        });
        $('#tabla-inventario').removeClass('d-none');
    }
/* }); */