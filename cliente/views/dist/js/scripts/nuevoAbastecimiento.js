var tabla;
/* $(function(){ */
var detalleAbastecimiento = [];

_init();

function _init() {
    cargarProveedores();
    cargarProductos();
    agregarItemProducto();
    guardarAbastecimiento();
    listarAbastecimiento();
}

function cargarProveedores() {
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'proveedores/listar',
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                let tr = '';
                let i = 1;
                response.proveedor.forEach(element => {
                    tr += `<tr id="fila-proveedor-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.ruc}</td>
                        <td>${element.nombre_proveedor}</td>
                        <td>
                          <div class="div">
                            <button class="btn btn-primary btn-sm" data-dismiss="modal" onclick="seleccionar_proveedor(${element.id})">
                              <i class="fas fa-check"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                    i++;
                });
                $('#proveedores-body').html(tr);
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
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'productos/listar',
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                let tr = '';
                let i = 1;
                response.producto.forEach(element => {
                    tr += `<tr id="fila-producto-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.nombre}</td>
                        <td style="display: none">${element.categorias.categoria}</td>
                        <td>${element.stock}</td>
                        <td style="display: none">${element.imagen}</td>
                        <td>
                          <div class="div">
                            <button class="btn btn-primary btn-sm" data-dismiss="modal" onclick="seleccionar_producto(${element.id})">
                              <i class="fas fa-check"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                    i++;
                });
                $('#productos-body').html(tr);
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

function agregarItemProducto() {
    $('#item-agregar').click(function (e) {
        e.preventDefault();
        let id = $('#producto-id').val();
        let nombre = $('#producto-nombre').val();
        let cantidad = $('#producto-cantidad').val();

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if (id.length == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Seleccione un producto'
            })
        } else if (cantidad.length == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Ingrese una cantidad'
            })
        } else {
            let json = {
                producto_id: parseInt(id),
                nombre: nombre,
                cantidad: parseInt(cantidad)
            }


            let tBody = document.getElementById('items-productos');
            tBody.innerHTML = '';
            if (tBody != null) {
                let arrayPro = validarRepetidos(json);
                console.log(arrayPro);
                if (arrayPro.length > 0) {
                    arrayPro.forEach(e => {
                        const tr = document.createElement('tr');
                        tr.classList.add('removePro');
                        contenido = `
                            <td><i class="fas fa-star-of-life"></i></td>
                            <td>${e.nombre}</td>
                            <td>${e.cantidad}</td>
                            <td class="total_producto">${e.cantidad}</td>
                            <th>
                                    <div>
                                        <button class="btn btn-outline-dark delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                            </th>
                            <th style="display:none;" class="id">${e.producto_id}</th>
                        `;
                        tr.innerHTML = contenido;
                        tBody.append(tr)
                        tr.querySelector('.delete').addEventListener('click', borrarProducto);
                    });
                }
                $('#table-detalle-abastecer').removeClass('d-none');
                resetProducto();
            }
        }
    });
}

function validarRepetidos(json) {
    for (let i = 0; i < detalleAbastecimiento.length; i++) {
        if (detalleAbastecimiento[i].producto_id === json.producto_id) {
            detalleAbastecimiento[i].cantidad = detalleAbastecimiento[i].cantidad + json.cantidad;
            return detalleAbastecimiento;
        }
    }

    detalleAbastecimiento.push(json)
    return detalleAbastecimiento;
}

function borrarProducto(e) {
    const btn = e.target;
    const trPadre = btn.closest('.removePro');
    let id = Number(trPadre.querySelector('.id').innerHTML);

    for (let i = 0; i < detalleAbastecimiento.length; i++) {
        if (detalleAbastecimiento[i].producto_id === id) {
            detalleAbastecimiento.splice(i, 1);
        }
    }
    trPadre.remove();
}

function guardarAbastecimiento() {
    $('#formulario-nuevo-abastecer').submit((e) => {
        e.preventDefault();

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        let proveedores_id = $('#prov-id').val();
        let usuarios_id = JSON.parse(sessionStorage.getItem('sesion')).id;

        let items = $('.total_producto');

        //detalle abastecer
        let productos = $('.fila-productos');
        if (proveedores_id == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Seleccione un proveedor'
            })

        } else if (items.length == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Seleccione al menos un producto'
            })
        } else {
            let detalles = [];
            for (let i = 0; i < detalleAbastecimiento.length; i++) {

                let productos_id = detalleAbastecimiento[i].producto_id;
                let cantidad = detalleAbastecimiento[i].cantidad;

                let aux = {
                    productos_id, cantidad
                };
                detalles.push(aux);
            }

            let json = {
                abastecer: {
                    proveedores_id: proveedores_id,
                    usuarios_id: usuarios_id,
                },
                detalle_abastecer: detalles
            };

            guardandoabastecimiento(json);
        }
    });
}

function guardandoabastecimiento(json) {
    $.ajax({
        url: urlServidor + 'abastecer/guardar',
        type: 'POST',
        data: 'data=' + JSON.stringify(json),
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
                $('#formulario-nuevo-abastecer')[0].reset();
                $('#prov-id').val('');
                $('#prov-ruc').val('');
                $('#prov-nombre').val('');
                $('#items-productos').html('');
                $('#table-detalle-abastecer').addClass('d-none');
                listarAbastecimiento();
                cargarProductos();
                detalleAbastecimiento = [];
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response.mensaje
                })
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

function listarAbastecimiento() {
    tabla = $('#tabla-abastecimientos').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        buttons: [
        ],
        "ajax":
        {
            url: urlServidor + 'abastecer/listar',
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
}

/* }); */

function seleccionar_proveedor(id) {
    let fila = '#fila-proveedor-' + id;
    let f = $(fila)[0].children;

    let ruc = f[2].innerText;
    let nombreproveedor = f[3].innerText;

    $('#prov-id').val(id);
    $('#prov-ruc').val(ruc);
    $('#prov-nombre').val(nombreproveedor);
}

function seleccionar_producto(id) {
    let fila = '#fila-producto-' + id;
    let f = $(fila)[0].children;

    let nombreProducto = f[2].innerText;
    let categoria = f[3].innerText;
    let stock = f[4].innerText;
    let imagen = f[5].innerText;
    let img = (imagen != 'producto_default.jpg') ? urlServidor + 'resources/productos/' + imagen : urlServidor + 'resources/productos/producto_default.jpg';

    $('#producto-id').val(id);
    $('#producto-nombre').val(nombreProducto);
    $('#producto-categoria').val(categoria);
    $('#producto-stock').val(stock);
    $('#producto-imagen').attr('src', img);
    $('#btn-borrar').show();
}

function borrar_item(id) {
    let tr = '#fila-producto-' + id;
    $(tr).remove();
}

function resetProducto() {
    let img = urlServidor + 'resources/productos/producto_default.jpg';
    $('#producto-id').val('');
    $('#producto-nombre').val('');
    $('#producto-categoria').val('');
    $('#producto-cantidad').val('');
    $('#producto-stock').val('');
    $('#producto-imagen').attr('src', img);
}