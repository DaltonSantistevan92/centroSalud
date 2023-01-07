/* $(function () { */
 
    _init(); 

    function _init() {
        cargarDoctor(); 
        iniciarCalendar();
    }

    function cargarDoctor(){
        let sesion = JSON.parse(sessionStorage.getItem('sesion')); 
        let doctores = sesion.personas.doctores;
            doctores.forEach(element => { 
                $('#doctor-id').val(element.id);
            });
    }

    function iniciarCalendar(){
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        
        let doct_id = document.getElementById('doctor-id').value;

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
            dateClick: function(info){
                const start = info.dateStr;
                var date = new Date(start);
                var hoy = new Date();
                hoy.setDate(hoy.getDate()+1);
                var ayer = new Date(hoy - 24 * 60 * 60 * 1000);

                if (date > ayer) {
                $('#fecha-doctor').val(info.dateStr);
                $('#modal-horario').modal('show'); 
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'No es posible agendar horas'
                    });
                }
            },
            events: urlServidor + 'horario/listarEventoDoctorHorario/'+doct_id,  
            eventClick: function(info){
                let fecha = info.event.startStr;
                let dia = fecha.substring(10,8);
                let doctor_id = $('#doctor-id').val();
                $('#modal-lista-horario').modal('show');   
                cargarDataHorario(doctor_id,dia);
            }
        });
        calendar.render();
        guardarHorario();
        calendar.refetchEvents();
    }

    function cargarDataHorario(doctor_id,dia){ 
        $.ajax({
            url:urlServidor  +'doctor_horario/listarHoraxDia/' + doctor_id + '/' + dia,
            type:'GET',
            dataType:'json',
            success:function(response){
                console.log(response);
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.dia.forEach(element => {
                        tr += ` <tr>
                                    <td>${i}</td>
                                    <td>${element.hora_atencion}</td>
                                    <td><span class="tag tag-warning">${element.fecha}</span></td>
                                    <td>
                                        <div class="text-center">
                                            <button class="btn btn-danger" onclick="eliminar_doctor_horario(${element.id},${doctor_id})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>`;
                        i++
                    }); 
                    $('#body-lista-horario').html(tr);
                }else{
                    let tr = `<tr>
                                <td></td>     
                                <td></td>
                                <td></td>
                                <td>${response.mensaje}</td>    
                                <td></td>           
                            </tr>`;
                    $('#body-lista-horario').html(tr);
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

    function guardarHorario(){
        $('#form-horario-doctor').submit(function(e){ 
           e.preventDefault();

           let doctores_id = $('#doctor-id').val();
           let hora_entrada = $('#hora-entrada').val();
           let hora_salida =  $('#hora-salida').val();
           let fecha= $('#fecha-doctor').val();
           let intervalo= $('#intervalo-doctor option:selected').val();
           
           let horaAtencion = '07:00'; 
           let horaFinAtencion = '18:00';

           var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
            });

           if(hora_salida < hora_entrada){
            Toast.fire({
                icon: 'error',
                title: 'La hora de salida no puede ser menor a la hora de entrada'
              });
           }else if(hora_entrada == hora_salida){ 
            Toast.fire({
                icon: 'error',
                title: 'La hora de entrada no puede ser igual a la hora de salida'
              });
           }else if(hora_entrada < horaAtencion){
            Toast.fire({
                icon: 'error',
                title: 'La hora de entrada no puede ser menor a la hora de atencion (7:00 am)'
              });
           }else if(hora_salida > horaFinAtencion){
            Toast.fire({
                icon: 'error',
                title: 'Solo se gestiona hasta las (18:00 pm)'
              });
           }
           else {
                let json = {
                    horario:{
                       hora_entrada,
                       hora_salida,
                       fecha,
                       intervalo 
                    },
                    doctor: {
                        doctores_id
                    }
                };
                guardandoHorarios(json);
           }
       });
    }

    function guardandoHorarios(json){
        $.ajax({
            url:urlServidor  + 'horario/guardarHorario', 
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
                    $('#form-horario-doctor')[0].reset();
                    $('#modal-horario').modal('hide');
                    window.location.reload();
                    //window.location.href = window.location.href;
                } else{
                    Toast.fire({
                        icon: 'error',
                        title: response.mensaje
                    });
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
/* }); */

    function eliminar_doctor_horario(horario_id,doctor_id,){ 
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'horario/eliminarDoctorHorario/'+ horario_id + '/' + doctor_id, 
            // especifica si será una petición POST o GET
            type : 'DELETE',
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
                    });
                    $('#modal-lista-horario').modal('hide');
                    iniciarCalendar();
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
