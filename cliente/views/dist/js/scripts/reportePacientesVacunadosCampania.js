/* $(function(){ */

    _init();

    function _init(){
        abrirModalCampania();
        cargarCampanias();
        cargarData();
        imprimir();
    }

    function abrirModalCampania() {
        $('#buscar-datos-campania').click(function () {
            $('#modal-campanias').modal('show');
        });
    }

    function cargarCampanias(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'campania/listar', 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.campania.forEach(element => {
                        tr += `<tr id="fila-campania-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.nombre}</td>
                        <td>
                          <div>
                            <button class="btn btn-primary btn-sm" onclick="seleccionar_campania(${element.id})">
                              <i class="fas fa-check"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                      i++;
                    });
                    $('#campanias-body').html(tr);
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

    function cargarData(){
        $('#btn-consulta').click(function(){
            
            let fecha_inicio = $('#fecha-inicio-r-m').val();
            let fecha_fin = $('#fecha-fin-r-m').val();
            let limite = $('#limite option:selected').val();
            let campania_id = $('#campania-id-reporte').val();

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            
            if(fecha_inicio.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione una fecha de inicio'
                })
            }else
            if(fecha_fin.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione una fecha fin'
                })
            }else{
              if(moment(fecha_inicio).isAfter(fecha_fin)){
                Toast.fire({
                    icon: 'info',
                    title: 'La fecha fin no puede ser menor'
                })
            }else
            if(limite == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione un Limite'
                })
            }else
            if(campania_id.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione una campaña'
                })
            }else{
                let f = new Date();
                let fecha = f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear();
                let hora = f.getHours() + ':' + (f.getMinutes()) + ':' + f.getSeconds();

                $('#fecha-inicio-r-m2').text(fecha_inicio);
                $('#fecha-fin-r-m2').text(fecha_fin);
                $('#fecha-consulta-s').text(fecha);
                $('#hora-consulta-s').text(hora);

                $.ajax({
                    // la URL para la petición
                    url : urlServidor + 'aplicar_vacuna/pacienteVacunadoxCampania/' + campania_id + '/' + fecha_inicio + '/' + fecha_fin + '/' + limite,
                    // especifica si será una petición POST o GET
                    type : 'GET',
                    // el tipo de información que se espera de respuesta
                    dataType : 'json',
                    success : function(response) { 
                        if(response.status){
                            let tr = '';
                            let i = 1;
                            let dosis= '';
                            let dosisf = 0;
                            
                            response.data.forEach(element => {
                                $('#campana-reporte').text(element.nombre_campania);
                                element.data_paciente.dosis.forEach(d => {
                                    dosis = d;
                                    dosisf += d;
                                });
                                element.data_paciente.paciente.forEach(e => {
                                    tr += `<tr>
                                            <td>${i}</td>
                                            <td>${e.personas.nombre} ${e.personas.apellido}</td>
                                            <td>${dosis}</td>
                                            <td>${element.nombreProducto}</td>
                                        </tr>`;
                                        i++;                              
                                    });
                                });

                            $('#body-reporte-data').html(tr);  
                            $('#tabla-reporte-data').removeClass('d-none');
                            $('#total-general').text(dosisf);  
                        }else{
                            Toast.fire({
                                icon: 'info',
                                title: 'No hay informacion disponible'
                            })
                            $('#tabla-reporte-data').addClass('d-none');
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
            }
        });
    }

    function imprimir(){
        $('#btn-imprimir').click(function(){
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            
            let data = $('#body-reporte-data tr');
            if (data.length == 0) {
                Toast.fire({
                    icon: 'info',
                    title: 'No hay información disponible en la tabla'
                })
            } else {
                let element = document.getElementById('tabla-reporte-data');
    
                    let opt = {
                    margin:       0.5,
                    filename:     'Reporte Pacientes Vacunados Por Campaña.pdf',
                    image:        { type: 'jpeg', quality: 3 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'in', format: 'ledger', orientation: 'portrait' }
                    };
                    html2pdf().set(opt).from(element).save();
            }
        });
    }

/* }); */

function seleccionar_campania(id) {
    let fila = '#fila-campania-' + id;
    let f = $(fila)[0].children;

    let campania = f[2].innerText;

    $('#campania-id-reporte').val(id);
    $('#campania-texto').val(campania);
    $('#modal-campanias').modal('hide');
}