/* $(function () { */

    _init();

    function _init() {
        cargarDoctores();
        cargarEspecialidades();
        guardarAsignacion();
        listarAsignaciones();
    }

    function cargarDoctores(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'doctores/listarDoctor', 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.doctor.forEach(element => {
                        tr += `<tr id="fila-doctor-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.personas.cedula}</td>
                        <td>${element.personas.nombre} ${element.personas.apellido}</td>
                        <td>
                          <div>
                            <button class="btn btn-primary btn-sm" onclick="seleccionar_doctor(${element.id})">
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
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        }); 
    }

    function cargarEspecialidades(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'especialidad/listar', 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.especialidad.forEach(element => {
                        tr += `<tr id="fila-especialidad-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.especialidad}</td>
                        <td>
                          <div>
                            <button class="btn btn-primary btn-sm" onclick="seleccionar_especialidad(${element.id})">
                              <i class="fas fa-check"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                      i++;
                    });
                    $('#especialidad-body').html(tr);
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

    function guardarAsignacion(){
        $('#asignar-especialidad').click(function(){  
            let doctores_id = $('#doctor-id').val();
            let especialidad_id = $('#especialidad-id').val();

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            if(doctores_id.length == 0){
                  Toast.fire({
                    icon: 'info',
                    title: 'Debe seleccionar un doctor'
                });
            }else
            if(especialidad_id.length == 0){
                  Toast.fire({
                    icon: 'info',
                    title: 'Debe seleccionar una especialidad'
                });
            }else{
               let json = {
                    doctores_especialidad: {
                        doctores_id,
                        especialidad_id,
                    },
                };

                guardandoAsignacion(json);
            }
        });
    }

    function guardandoAsignacion(json){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'doctores_especialidad/guardar',
            // especifica si será una petición POST o GET
            type : 'POST',
            data : "data=" + JSON.stringify(json),
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
                    reset();
                    listarAsignaciones();
                }else{
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

    function reset(){ 
        $('#doctor-id').val('');
        $('#doc-seleccionado').text('----------');
        $('#especialidad-id').val('');
        $('#esp-seleccionado').text('----------');
    }

    function listarAsignaciones(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'doctores_especialidad/listar', 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.doctores_especialidad.forEach(element => {
                        tr += `<tr id="fila-doctor_esp-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.doctores.personas.nombre} ${element.doctores.personas.apellido}</td>
                        <td>${element.especialidad.especialidad}</td>
                        <td>
                          <div>
                            <button class="btn btn-primary btn-sm" onclick="eliminarAsignacion(${element.id})">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                      i++;
                    });
                    $('#asignacion-body').html(tr);
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

function seleccionar_doctor(id) {
    let fila = '#fila-doctor-' + id;
    let f = $(fila)[0].children;

    let cedula_doctor = f[2].innerText;
    let doctor_nombre = f[3].innerText;

    $('#doctor-id').val(id);
    $('#doc-seleccionado').text(doctor_nombre);
}

function seleccionar_especialidad(id) {
    let fila = '#fila-especialidad-' + id;
    let f = $(fila)[0].children;

    let especialidad_nombre = f[2].innerText;

    $('#especialidad-id').val(id);
    $('#esp-seleccionado').text(especialidad_nombre);
}

function eliminarAsignacion(id){
    $.ajax({
        // la URL para la petición
        url : urlServidor + 'doctores_especialidad/eliminarDoctorEspecialidad/'+ id, 
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
                listarAsignaciones();
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