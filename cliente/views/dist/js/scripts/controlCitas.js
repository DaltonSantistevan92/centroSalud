/* $(function () { */

_init();
var detallePro = [];

function _init() {
    $('#btn-borrar').hide();
    listarTablasCitasPendientesXDoctor();
    listarTablasCitasAtendidasXDoctor();
    listarTablasCitasCanceladasXDoctor();
    cargarProductos();
    agregarItemProducto();
    borrarDatosProducto();
    guardarReceta();
    buscarProducto();
}

function listarTablasCitasPendientesXDoctor() {
    let sesion = JSON.parse(sessionStorage.getItem('sesion'));
    let personas_id = sesion.personas.id;
    let estado_id = 1;
    tabla = $('#tabla-citas-pendientes').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        buttons: [
        ],
        "ajax":
        {
            url: urlServidor + 'citas/pendientesDataTable/' + personas_id + '/' + estado_id,
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

function listarTablasCitasAtendidasXDoctor() {
    let sesion = JSON.parse(sessionStorage.getItem('sesion'));
    let personas_id = sesion.personas.id;
    let estado_id = 2;
    tabla = $('#tabla-citas-atendidas').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        buttons: [
        ],
        "ajax":
        {
            url: urlServidor + 'citas/listarCitasAtendidasxDoctor/' + personas_id + '/' + estado_id,
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

function listarTablasCitasCanceladasXDoctor() {
    let sesion = JSON.parse(sessionStorage.getItem('sesion'));
    let personas_id = sesion.personas.id;
    let estado_id = 3;
    tabla = $('#tabla-citas-canceladas').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        buttons: [
        ],
        "ajax":
        {
            url: urlServidor + 'citas/listarCitasCanceladasxDoctor/' + personas_id + '/' + estado_id,
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

function cargarProductos() {
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'productos/listarParaReceta',
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
                        <td>${element.stock}</td>
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

function guardarReceta() {
    $('#guardar-receta').click(function () {

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        let citas_id = $('#cita_id').val();
        let descripcion = $('#receta-descripcion').val();

        let items = $('.total_producto');

        //detalle abastecer
        //let productos = $('.fila-productos');
        let arrayPro = detallePro;
        if (descripcion.length == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Ingrese RX (descripción)'
            })

        } else {
            let detalles = [];
            for (let i = 0; i < arrayPro.length; i++) {

                let productos_id = arrayPro[i].producto_id;
                let cantidad = arrayPro[i].cantidad;

                let aux = {
                    productos_id, cantidad
                };
                detalles.push(aux);
            }

            let json = {
                receta: {
                    citas_id: citas_id,
                    descripcion: descripcion,
                },
                detalle_receta: detalles
            };
            if(detalles.length > 0) {
                guardandoreceta(json);
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'Registre los medicamentos'
                })
                return;  
            }
        }
    });
}

function guardandoreceta(json) {
    $.ajax({
        url: urlServidor + 'recetas/guardar',
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
                $('#receta-descripcion').val('');
                $('#listProdReceta').html('');
                $('#table-detalle-receta').addClass('d-none');
                $('#modal-receta').modal('hide');
                listarTablasCitasPendientesXDoctor();
                listarTablasCitasAtendidasXDoctor();
                listarTablasCitasCanceladasXDoctor();
                cargarProductos();
                detallePro = [];
                location.reload();
                //$('#cita_id').val('');
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

/* }); */

function cancelarCita(id, estado_cita_id) {
    Swal.fire({
        title: 'Desea Cancelar la cita?',
        text: "Al cancelar la cita no se podrá revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            estado_cita_id = 3
            $.ajax({
                // la URL para la petición
                url: urlServidor + 'citas/cancelarxDoctor/' + id + '/' + estado_cita_id,
                // especifica si será una petición POST o GET
                type: 'GET',
                // el tipo de información que se espera de respuesta
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
                        listarTablasCitasPendientesXDoctor();
                        listarTablasCitasAtendidasXDoctor();
                        listarTablasCitasCanceladasXDoctor();
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
    });
}

function seleccionar_producto(id) {
    let fila = '#fila-producto-' + id;
    let f = $(fila)[0].children;

    let nombreProducto = f[2].innerText;
    let stock = f[3].innerText;

    $('#producto-id').val(id);
    $('#producto-nombre').val(nombreProducto);
    $('#producto-stock').val(stock);
    $('#btn-borrar').show();
}

function agregarItemProducto() {
    $('#agregar-producto').click(function () {
        //let arrayProductos = [];
        let id = $('#producto-id').val();
        let nombre = $('#producto-nombre').val();
        let cantidad = $('#producto-cantidad').val();
        let stock = $('#producto-stock').val();

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
            }); return;
        } else if (cantidad.length == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Ingrese una cantidad'
            }); return;
        } else if(parseInt(cantidad) > parseInt(stock)){
            Toast.fire({
                icon: 'info',
                title: 'La cantidad es mayor al stock disponible'
            }); return;
        } else {
            let json = {
                producto_id: parseInt(id),
                nombre: nombre,
                cantidad: parseInt(cantidad)
            }

            let tBody = document.getElementById('listProdReceta');
            tBody.innerHTML = '';
            if (tBody != null){
                let arrayProductos = validarRepetidos(json);
                if(arrayProductos.length > 0){
                    arrayProductos.forEach(e => {
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
            }
            
            $('#table-detalle-receta').removeClass('d-none');
            resetProducto();
        }
    });
}

function validarRepetidos(json){
    for (let i = 0; i < detallePro.length; i++) {
        if(detallePro[i].producto_id === json.producto_id){
            detallePro[i].cantidad = detallePro[i].cantidad + json.cantidad; 
            return detallePro;
        }
    }
    console.log(detallePro);
    detallePro.push(json)
    return detallePro;
}

function borrarProducto(e){
    const btn = e.target;
    const trPadre = btn.closest('.removePro');
    let id =  Number(trPadre.querySelector('.id').innerHTML);

    for (let i = 0; i < detallePro.length; i++) {
        if(detallePro[i].producto_id === id){
            detallePro.splice(i, 1);
        }
    }
    trPadre.remove();
}

function borrar_item(id) {
    let tr = '#fila-producto-' + id;
    $(tr).remove();
}

function resetProducto() {
    $('#producto-id').val('');
    $('#producto-nombre').val('');
    $('#producto-cantidad').val('');
    $('#producto-stock').val('');
    $('#btn-borrar').val('');
}

function borrarDatosProducto() {
    $('#btn-borrar').click(function () {
        resetProducto();
    });
}

function atenderCita(id) {
    Swal.fire({
        title: 'Esta seguro de atender la cita?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#modal-receta').modal('show');
            $('#cita_id').val(id);
            $.ajax({
                url: urlServidor + 'citas/updateEntrada/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        //console.log(response);
                    }
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                    //console.error(error);
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
            $.ajax({
                url: urlServidor + 'citas/listar/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#receta-nombre-paciente').text(response.citas.pacientes.personas.nombre + ' ' + response.citas.pacientes.personas.apellido);
                    }
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        };
    })
}

function buscarProducto(){
    $('#busqueda').keyup(function(){
        let texto = $('#busqueda').val();
        $.ajax({
            url:urlServidor  +'productos/search/' + texto,
            type:'GET',
            dataType:'json',
            success:function(response){              
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                //console.log(response);
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.producto.forEach(element => {
                        tr += `<tr id="fila-producto-${element.id}">
                            <td>${i}</td>
                            <td style="display: none">${element.id}</td>
                            <td>${element.nombre}</td>
                            <td>${element.stock}</td>
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
    });
}

function verCita(id) {
    $('#modal-verCita').modal('show');
    $.ajax({
        url: urlServidor + 'citas/listar/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                $('#cita-doctor-m').text(response.citas.doctores.personas.nombre + ' ' + response.citas.doctores.personas.apellido);
                $('#cita-paciente-m').text(response.citas.pacientes.personas.nombre + ' ' + response.citas.pacientes.personas.apellido);
                $('#cita-espe-m').text(response.citas.especialidad.especialidad);
                $('#cita-fecha-m').text(response.citas.fecha);
                $('#cita-hora-m').text(response.citas.horario.hora_atencion);
                let estad_cita = response.citas.estado_cita.id;
                let detalleCita = '';
                if (estad_cita == 1) {
                    detalleCita = 'PENDIENTE'
                } else if (estad_cita == 3) {
                    detalleCita = 'CANCELADO'
                } else if (estad_cita == 2) {
                    detalleCita = 'ATENDIDA'
                } else {
                    detalleCita = 'ENTREGADO'
                }
                $('#cita-estado-m').text(detalleCita);
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
