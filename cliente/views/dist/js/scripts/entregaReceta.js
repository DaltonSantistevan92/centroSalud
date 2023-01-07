
_init();

function _init() {
    listarTablasCitasEntregadasyNoEntregadas();
    imprimir();
    verEscalas();
}

function listarTablasCitasEntregadasyNoEntregadas() {
    tabla = $('#tabla-citas-entregadas-no').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        buttons: [
        ],
        "ajax":
        {
            url: urlServidor + 'citas/listarCitasAtendidaEntregadayNoEntregada',
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

function listarTablasCitasNoEntregadas() {
    tabla = $('#tabla-entrega-receta').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        buttons: [
        ],
        "ajax":
        {
            url: urlServidor + 'citas/listarCitasAtendidaPeroNoEntregada',
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

function listarTablasCitasEntregadas() {
    tabla = $('#tabla-citas-entregadas').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        buttons: [
        ],
        "ajax":
        {
            url: urlServidor + 'citas/listarCitasEntregada',
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

function imprimir() {
    $('#btn-imprimir').click(function () {
        let element = document.getElementById('receta-detalle');

        let opt = {
            margin: 0.5,
            filename: 'Receta.pdf',
            image: { type: 'jpeg', quality: 3 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'legal', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    });
}

function verEscalas() {
    $.ajax({
        url: urlServidor + '/escala_satisfacion/listar',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            let div = "";
            if (response.status) {
                let escalas = response.escala;

                escalas.forEach(e => {
                    div += `
                        <div class="col-sm d-flex flex-column justify-content-center align-items-center" id="fila-${e.id}" onClick="calificar(${e.id})">
                            <img width="80" height="80" src="${urlServidor}resources/svgIcon/${e.name_svg}" alt="user-avatar" class="img-fluid svg-icon" id="svg-${e.id}">
                            <div class="text-uppercase text-center">${e.detalle}</div>
                        </div>
                    `;
                });
                $('#valoracion').html(div);

            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
    });
}

function calificar(id) {
    $('#valor').val(id);

    $('.svg-icon').removeClass('svg-selected');

    $(`#svg-${id}`).addClass("svg-selected");
}


function entregaProducto(citas_id, estado_cita) {
    //alert('este id viene del backend'+ citas_id);

    $('#modal-satisfaccion').modal('show');
    guardarInfo(citas_id, estado_cita);

}


function guardarInfo(citas_id, estado_cita) {
    //alert('guarda info cita id'+ citas_id);

    $('#btn-guardarSas').click( function() {
        let valor = $('#valor').val();
        if (valor == '') { valor = 1; }

        $.ajax({
            // la URL para la petición
            url: urlServidor + 'citas/entregaProductoxReceta/' + citas_id + '/' + estado_cita + '/' + valor,
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
                    });
                    $('#modal-satisfaccion').modal('hide');
                    $('.svg-icon').removeClass('svg-selected');
                    $('#valor').val('');
                    listarTablasCitasEntregadasyNoEntregadas();
                    location = location;
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        });
    });
}

function verProductoEntregados(id) {
    $('#modal-receta').modal('show');
    $.ajax({
        url: urlServidor + 'citas/verCitasEntregadas/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status) {
                $('#doctor-receta').text(response.citas.doctores.personas.nombre + ' ' + response.citas.doctores.personas.apellido);
                $('#especialidad-receta').text(response.citas.especialidad.especialidad);
                $('#receta-paciente-cedula').text(response.citas.pacientes.personas.cedula);
                $('#receta-paciente-nombre').text(response.citas.pacientes.personas.nombre + ' ' + response.citas.pacientes.personas.apellido);

                let tr = '';
                response.citas.recetas.forEach(element => {
                    element.detalle_receta.forEach((e, i) => {
                        tr += `<tr>
                                    <td style="color: black;">${i + 1} </td>
                                    <td style="color: black;">${e.productos.nombre}</td>
                                    <td style="color: black;">${e.cantidad}</td>
                                    <td style="color: black;">${e.cantidad}</td>
                                </tr>`;
                    });
                });
                $('#list-detalle').html(tr);
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