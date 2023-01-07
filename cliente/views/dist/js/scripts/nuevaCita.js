/* $(function () { */

    _init();

    function _init(){
        cargarDoctor();
        iniciarCalendar();
        cambioSelectHorario();
        cargarPacientes();
        guardarCita();
        //resetDatos();
        buscarPaciente();
        listarTablasCitas();
    }

    function iniciarCalendar(){
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        let doctor_id = $('#doctor-id').val();

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
              left  : 'prev,next,today',
              center: 'title',
              right : 'dayGridMonth'
            },
            validRange:{
                start: '2021-01-01'
            },
            events: urlServidor + 'horario/listarEventoDoctorHorario/' + doctor_id,  
            eventClick: function(info){
                let fecha = info.event.startStr;
                $('#fecha-doctor').val(fecha);
                let dia = fecha.substring(10,8);
                let doctor_id = $('#doctor-id').val();
                $('#modal-lista-horario-disponible').modal('show');   
               cargarHorariosDisponiblesXDoctor(doctor_id,dia);
            } 
        });
        calendar.render();
    }

    function cargarDoctor() {
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'doctores/listarDoctor',
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let tr = '';
                    let i = 1;
                    response.doctor.map(element => {
                        tr += `<tr id="fila-doct-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.personas.nombre} ${element.personas.apellido}</td>
                        <td>
                          <div class="div">
                            <button class="btn btn-primary btn-sm" data-dismiss="modal" onclick="seleccionar_doctor(${element.id})">
                              <i class="fas fa-check"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                        i++;
                    });
                    $('#doctor-body').html(tr);
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

    function cargarHorariosDisponiblesXDoctor(doctor_id,dia){ 
        $.ajax({
            url:urlServidor  +'doctor_horario/listarHoraxDia/' + doctor_id + '/' + dia,
            type:'GET',
            dataType:'json',
            success:function(response){
                if(response.status){
                    let option = '<option value="0">Seleccione un Horario</option>';
                    response.dia.forEach(element=>{
                         option +=`<option value=${element.id}>${element.hora_atencion}</option>`;
                    });
                    $('#horario-doctor-disponible').html(option);
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

    function cambioSelectHorario(){
        $('#form-horario-disponible').submit(function(e){
            e.preventDefault();
            
            let fecha= $('#fecha-doctor').val();
            let horario_id  = $('#horario-doctor-disponible option:selected').val();
            let horario_texto  = $('#horario-doctor-disponible').find('option:selected').text();

            $('#fecha-hor').val(fecha);
            $('#horario-texto').val(horario_texto);
            $('#modal-lista-horario-disponible').modal('hide'); 
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
                if (response.status) {
                    let tr = '';
                    let i = 1;
                    response.paciente.forEach(element => {
                        tr += `<tr id="fila-paciente-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.personas.cedula}</td>
                        <td>${element.personas.nombre} ${element.personas.apellido}</td>
                        <td>
                          <div class="div">
                            <button class="btn btn-primary btn-sm" data-dismiss="modal" onclick="seleccionar_paciente(${element.id})">
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
            },
            complete: function (jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function buscarPaciente(){
        $('#busqueda').keyup(function(){
            let texto = $('#busqueda').val();
            $.ajax({
                url:urlServidor  +'pacientes/search/' + texto,
                type:'GET',
                dataType:'json',
                success:function(response){              
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    console.log(response);
                    if(response.status){
                        let tr = '';
                        let i = 1;
                        response.pacientes.forEach(element => {
                            tr += `<tr id="fila-paciente-${element.id}">
                            <td>${i}</td>
                            <td style="display: none">${element.id}</td>
                            <td>${element.cedula}</td>
                            <td>${element.nombre} ${element.apellido}</td>
                            <td>
                            <div class="div">
                                <button class="btn btn-primary btn-sm" data-dismiss="modal" onclick="seleccionar_paciente(${element.id})">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                            </td>
                            </tr>`;
                            i++;
                        });
                        $('#paciente-body').html(tr);
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

    function guardarCita(){
        $('#btn-guardar-cita').click(function(){

           let sesion = JSON.parse(sessionStorage.getItem('sesion'));
           let usuarios_id = sesion.id 
           let doctores_id = $('#doctor-id').val();
           let horario_id = $('#horario-doctor-disponible option:selected').val();
           let especialidad_id = $('#especialidad-id').val();
           let pacientes_id = $('#paciente-id').val();
           let fecha = $('#fecha-hor').val();

           let json = {
               cita:{
                    usuarios_id,
                    doctores_id,
                    horario_id,
                    especialidad_id,
                    pacientes_id,
                    fecha      
               },
           };

           //validacion para datos de usuario
           if(!validarCita(json)){
               console.log('llene los datos de usuario');
           }else{
               console.log(json);
               guardandocita(json);
           }
        });
    }

    function validarCita(json){
        let cita = json.cita;

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if(cita.doctores_id == 0){
            Toast.fire({
                icon: 'error',
                title: 'Seleccione un doctor'
            })
            return false;
        }else if(cita.pacientes_id == 0){
            Toast.fire({
                icon: 'error',
                title: 'Seleccione un paciente'
            })
            return false;
        }else if (cita.horario_id === undefined){
            Toast.fire({
                icon: 'error',
                title: 'Seleccione un horario'
            })
            return false;
        }else if(cita.servicios_id == 0){
            Toast.fire({
                icon: 'error',
                title: 'Seleccione un servicio'
            });
            return false;
        }else {
            return true;
        }
    }

    function guardandocita(json){
        $.ajax({
            url:urlServidor  +'citas/guardarCita',
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
                   });
                    resetDatos();
                    iniciarCalendar();
                    listarTablasCitas();
                } else{
                 Toast.fire({
                     icon: 'error',
                     title: response.mensaje
                   });
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        });
    }

    function resetDatos(){
        $('#doctor-id').val('');
        $('#nombre-doctor').val('');
        $('#paciente-id').val('');
        $('#cedula-paciente').val('');
        $('#nombre-paciente').val('');
        $('#horario-doctor-disponible option:selected').val('');
        $('#fecha-hor').val('');
        $('#horario-texto').val('');
        $('#especialidad-id').val('');
        $('#espe-cita').val('');       
    }

    function listarTablasCitas(){
        tabla=$('#tabla-citas').dataTable({
            "lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [		          
                    ],
            "ajax":
                    {
                        url:  urlServidor + 'citas/listarCitasDataTable', 
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

function seleccionar_doctor(id) {
    let fila = '#fila-doct-' + id;
    let f = $(fila)[0].children;

    let doctor_nombre = f[2].innerText;

    $('#doctor-id').val(id);
    $('#nombre-doctor').val(doctor_nombre);

    $.ajax({
        url:urlServidor  +'doctores/listarDoctorEspecialidad/'+id,
        type:'GET',
        dataType:'json',
        success:function(response){
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            let data = response.doctor.doctores_especialidad;
            if(!data.length == 0){    
                data.forEach(element => {
                    $('#especialidad-id').val(element.especialidad.id);
                    $('#espe-cita').val(element.especialidad.especialidad);   
                });
            }else if(data.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'El docente no tiene especialidad'
                })
                $('#especialidad-id').val('');
                $('#espe-cita').val('');
            }
        },
        error : function(jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete : function(jqXHR, status) {
            // console.log('Petición realizada');
        }
    });

    iniciarCalendar();

    //window.location.reload();
}

function seleccionar_paciente(id) {
    let fila = '#fila-paciente-' + id;
    let f = $(fila)[0].children;

    let cedula = f[2].innerText;
    let nombrecompleto = f[3].innerText;

    $('#paciente-id').val(id);
    $('#cedula-paciente').val(cedula);
    $('#nombre-paciente').val(nombrecompleto);
}

function verCita(id){
    $('#modal-verCita').modal('show');
    $.ajax({
        url:urlServidor  +'citas/listar/' + id,
        type:'GET',
        dataType:'json',
        success:function(response){
            if(response.status){    
                $('#cita-doctor-m').text(response.citas.doctores.personas.nombre + ' ' + response.citas.doctores.personas.apellido);
                $('#cita-paciente-m').text(response.citas.pacientes.personas.nombre + ' ' + response.citas.pacientes.personas.apellido);
                $('#cita-espe-m').text(response.citas.especialidad.especialidad);
                $('#cita-fecha-m').text(response.citas.fecha);
                $('#cita-hora-m').text(response.citas.horario.hora_atencion);
                let estad_cita = response.citas.estado_cita.id;
                let detalleCita = '';
                if(estad_cita == 1){
                    detalleCita = 'PENDIENTE'
                }else if(estad_cita == 3){
                    detalleCita = 'CANCELADO'
                }else if(estad_cita == 2){
                    detalleCita = 'ATENDIDA'
                }else{
                    detalleCita = 'ENTREGADO'
                }
                $('#cita-estado-m').text(detalleCita);        
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

function cancelarCita(id,estado_cita_id){
    estado_cita_id = 3
    $.ajax({
        // la URL para la petición
        url : urlServidor + 'citas/cancelar/' + id + '/' + estado_cita_id, 
        // especifica si será una petición POST o GET
        type : 'GET',
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
                listarTablasCitas();
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


    