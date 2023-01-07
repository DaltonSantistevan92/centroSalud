
_init();

let stockVacunas = [];
let stockVacunasRestante = [];

function _init() {
    recuperarIdEnfermero();
    recuperarEnfermeroCampaniaIds();
    cargarPacientes();
    guardarVacunaPaciente();
    cargarTabla();
    desocuparEnfermero();
    buscarPaciente();
}

function recuperarIdEnfermero() {
    let sesion = JSON.parse(sessionStorage.getItem("sesion"));
    let enfermero = sesion.personas.enfermero;

    enfermero.map(e => {
        let enfermero_id = e.id;
        $('#enfermero_id').val(enfermero_id);
    });
}

function recuperarEnfermeroCampaniaIds() {
    let enfermero_id = $('#enfermero_id').val();
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'enfermero/listarEnfermeroCampania/' + enfermero_id,
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                let arrayCampaniaEnfermero = response.enfermero.campania_enfermero;
                arrayCampaniaEnfermero.forEach(e => {
                    let campania_id = e.campania.id;
                    $('#campania_id').val(campania_id);
                });

                let campania_id = $('#campania_id').val();
                cargarDataEnfermeroCampania(campania_id, enfermero_id);
                getVacunasAplicadas(campania_id);
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });
}

function cargarDataEnfermeroCampania(campania_id, enfermero_id) {
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'campania_enfermero/listarDetalles/' + campania_id + '/' + enfermero_id,
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        success: function (response) {
            //console.log(response);
            if (response.status) {
                let data = response.data;
                data.map(e => {
                    let nombreEnfermero = e.enfermero;
                    let nombreCampania = e.nombre_campaña;
                    let total_vacunas = e.total_vacuna; //5
                    let provincia = e.provincia;
                    let canton = e.canton;
                    let parroquia = e.parroquia;
                    let barrio = e.barrio;
                    let intervalo_edad = e.intervalo_edad;
                    let nombre_producto = e.nombre_producto;

                    const newObjec = {
                        stock: total_vacunas
                    }
                    stockVacunas.push(newObjec);

                    hacerUnaCopiaValidar(stockVacunas);
                    cargarValueLocalStorage();

                    let f = new Date();
                    let fecha = f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear();

                    $('#enfermero-nombre').val(nombreEnfermero);
                    $('#campania-nombres').val(nombreCampania);
                    $('#total-vacunas').val(total_vacunas);//original
                    $('#total-vacunas-text').text(total_vacunas);//original
                    $('#fecha').text(fecha);
                    $('#provincia').val(provincia);
                    $('#canton').val(canton);
                    $('#parroquia').val(parroquia);
                    $('#barrio').val(barrio);
                    $('#edad').val(intervalo_edad);
                    $('#nombre-vacuna').val(nombre_producto);
                });
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });

}


function buscarPaciente() {
    $('#buscar-paciente').keyup(function () {
        let texto = $('#buscar-paciente').val();
        $.ajax({
            url: urlServidor + 'pacientes/search/' + texto,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                if (response.status) {
                    let tr = '';
                    let i = 1;
                    response.pacientes.forEach(element => {
                        tr += `<tr id="fila-paciente-${element.id}">
                                    <td>${i}</td>
                                    <td style="display: none">${element.id}</td>
                                    <td>${element.cedula}</td>
                                    <td>${element.nombre}</td>
                                    <td>${element.apellido}</td>
                                    <td>${element.num_celular}</td>
                                    <td>${element.tipo}</td>
                                    <td>
                                    <div class="div text-center">
                                        <button class="btn btn-dark btn-sm" data-dismiss="modal" onclick="seleccionarPaciente(${element.id})">
                                        <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                    </td>
                                </tr>`;
                        i++;
                    });
                    $('#paciente-body').html(tr);
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
    });
}


function getVacunasAplicadas(campania_id) {
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'aplicar_vacuna/contarVacunasAplicadas/' + campania_id,
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                $('#vacunas-aplicada').text(response.vacuna);
                $('#vacunas-restante').text(response.vacuna_restante);

                let restanteNew = response.vacuna_restante;

                const newObjec = {
                    stock: restanteNew
                }
                stockVacunasRestante.push(newObjec);
                let cero = stockVacunasRestante[0].stock;
                console.log(cero);
                if (cero == 0) {
                    $('#vacunas-restante').text('0');
                }

                const existe = JSON.parse(localStorage.getItem('vacunas'));

                if (existe === null) {
                    console.log("data vacia");
                } else {
                    localStorage.removeItem('vacunas');
                    localStorage.setItem('vacunas', JSON.stringify(stockVacunasRestante));
                }

            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });
}

function cargarPacientes() {
    $.ajax({
        // la URL para la petición
        url: urlServidor + 'pacientes/listarPacientes',
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        success: function (response) {
            //console.log(response);
            if (response.status) {
                let tr = '';
                let i = 1;
                response.paciente.forEach(element => {
                    tr += `<tr id="fila-paciente-${element.id}">
                                <td>${i}</td>
                                <td style="display: none">${element.id}</td>
                                <td>${element.personas.cedula}</td>
                                <td>${element.personas.nombre}</td>
                                <td>${element.personas.apellido}</td>
                                <td>${element.personas.num_celular}</td>
                                <td>${element.personas.sexo.tipo}</td>
                                <td>
                                <div class="div text-center">
                                    <button class="btn btn-dark btn-sm" data-dismiss="modal" onclick="seleccionarPaciente(${element.id})">
                                    <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                </td>
                            </tr>`;
                    i++;
                });
                $('#paciente-body').html(tr);
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });
}

function seleccionarPaciente(id) {
    let fila = '#fila-paciente-' + id;
    let f = $(fila)[0].children;

    let cedula = f[2].innerText;
    let nombre = f[3].innerText;
    let apellido = f[4].innerText;
    let celular = f[5].innerText;
    let sexo = f[6].innerText;

    $('#paciente-id').val(id);
    $('#paciente-cedula').val(cedula);
    $('#paciente-nombre').val(nombre);
    $('#paciente-apellido').val(apellido);
    $('#paciente-celular').val(celular);
    $('#paciente-sexo').val(sexo);
}

function hacerUnaCopiaValidar(stockVacunas) {
    if (stockVacunas === undefined) {
        stockVacunas = [];
    } else {
        if (JSON.parse(localStorage.getItem('vacunas')) === null) {
            //alert('añadiendo al local primera vez');
            console.log('añadiendo al local primera vez');
            localStorage.setItem('vacunas', JSON.stringify(stockVacunas));
        } else {
            //alert('ya esta añadido solo muestra la data del local');
            console.log('ya esta añadido solo muestra la data del local');
        }
    }
}

function cargarValueLocalStorage() {
    const datalocal = JSON.parse(localStorage.getItem('vacunas'));

    datalocal.forEach(e => {
        $('#vacunas-restante').text(e.stock);//data del local storage
    });

}

function guardarVacunaPaciente() {
    $('#btn-vacunar').click(function () {

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        let enfermero_id = $('#enfermero_id').val();
        let campania_id = $('#campania_id').val();
        let pacientes_id = $('#paciente-id').val();
        let hora = $('#hora').val();
        let total_vacuna = $('#total-vacunas-text').text();
        let dosis = $('#dosis').val();

        let total_restante = $('#vacunas-restante').text();//5 local
        let vtr = validarCeroVacunasRestantes(total_restante);
        console.log(vtr);

        if (hora.length == 0) {
            Toast.fire({
                icon: 'info',
                title: 'Ingrese la hora de vacunación'
            }); return;
        } else
            if (pacientes_id.length == 0) {
                Toast.fire({
                    icon: 'info',
                    title: 'Ingrese un paciente'
                }); return;
            } else
                if (parseInt(total_restante) == 0 && vtr == false) {
                    Toast.fire({
                        icon: 'info',
                        title: 'No hay vacunas'
                    });
                }
                else {
                    let json = {
                        vacunar: {
                            enfermero_id: enfermero_id,
                            campania_id: campania_id,
                            pacientes_id: pacientes_id,
                            total_vacuna: total_vacuna,
                            total_aplicadas: dosis,
                            total_restante: total_restante,
                            hora: hora,
                        }
                    };
                    //console.log(json);
                    guardandoVacuna(json)
                }
    });
}

function guardandoVacuna(json) {
    let campania_id = json.vacunar.campania_id;
    $.ajax({
        url: urlServidor + 'aplicar_vacuna/guardar',
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
                });
                getVacunasAplicadas(campania_id);
                reset();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response.mensaje
                });
            }
        },
        error: function (jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        }
    });
}

function reset() {
    $('#paciente-id').val('');
    $('#paciente-cedula').val('');
    $('#paciente-nombre').val('');
    $('#paciente-apellido').val('');
    $('#paciente-celular').val('');
    $('#paciente-sexo').val('');
    $('#hora').val('');
}

function validarCeroVacunasRestantes(total_vacuna_local) {
    if (parseInt(total_vacuna_local) === null) {
        //alert('local vacio y se actualiza el text de vacunas restantes');
        //$('#vacunas-restante').text('0');
        return true;
    } else {
        if (parseInt(total_vacuna_local) > 0) {
            //alert('mostrando data');
            return true;
        } else {
            //alert('borrando data');
            localStorage.clear();
            return false;
        }
    }
}

function cargarTabla() {
    tabla = $('#tabla-vacunas').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
        buttons: [
        ],
        "ajax":
        {
            url: urlServidor + 'aplicar_vacuna/listarDataTableVacunacion',
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

function verCarnetVacunacion(id) {
    $('#modal-verCarnet').modal('show');
    $.ajax({
        url: urlServidor + 'aplicar_vacuna/listar/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            //console.log(response);
            if (response.status) {
                $('#vacuna-canton').text(response.vacuna.campania.cantones.nombre_canton);
                $('#vacuna-barrio').text(response.vacuna.campania.barrios.nombre_barrio);
                $('#cita-edad').text(response.vacuna.campania.intervalo_edad.edad);
                $('#vacuna-paciente-cedula').text(response.vacuna.pacientes.personas.cedula);
                $('#vacuna-paciente-nombre').text(response.vacuna.pacientes.personas.nombre + ' ' + response.vacuna.pacientes.personas.apellido);
                $('#vacuna-paciente-celular').text(response.vacuna.pacientes.personas.num_celular);
                $('#vacuna-nombre').text(response.vacuna.campania.detalle_campania[0].productos.nombre);
                $('#vacuna-dosis').text(response.vacuna.total_aplicadas + ' dosis');
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

function desocuparEnfermero() {
    $('#btn-desocupar').click(function () {
        Swal.fire({
            title: '¿Esta seguro de desocuparse de la campaña?',
            text: "Centro de Salud!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $('#enfermero_id').val();

                $.ajax({
                    url: urlServidor + 'aplicar_vacuna/desocuparEnfermero/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            Swal.fire(
                                'Vacunacion',
                                response.mensaje,
                                'success'
                            )
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
        })

    });
}