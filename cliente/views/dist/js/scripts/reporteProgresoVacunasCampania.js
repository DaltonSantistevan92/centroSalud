/* $(function(){ */

    _init();

    function _init(){
        abrirModalCampania();
        cargarCampanias();
        buscarCampania();
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

    function buscarCampania(){
        $('#buscar-campania').keyup(function(){
            let texto = $('#buscar-campania').val();
            $.ajax({
                // la URL para la petición
                url : urlServidor + 'campania/buscarCampania/' + texto,
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
                    }else{
                        $('#campanias-body').html('No hay información disponible');
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

    function cargarData(){
        $('#btn-consulta').click(function(){
            
            let fecha_inicio = $('#fecha-inicio-r-m').val();
            let fecha_fin = $('#fecha-fin-r-m').val();
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
                    url : urlServidor + 'aplicar_vacuna/progreso/' + campania_id + '/' + fecha_inicio + '/' + fecha_fin,
                    // especifica si será una petición POST o GET
                    type : 'GET',
                    // el tipo de información que se espera de respuesta
                    dataType : 'json',
                    success : function(response) { 
                        console.log(response);
                        if(response.status){
                            let tr = '';
                            let i = 1;
                            
                            response.data.forEach(element => {
                                tr += `<tr>
                                        <td>${i}</td>
                                        <td>${element.nombre_campania}</td>
                                        <td>${element.barrio}</td>
                                        <td>
                                            <div class="text-center">
                                                <span class="badge bg-warning" style="font-size: 1.2rem;">${element.total_vacuna}</span>   
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <span class="badge bg-danger" style="font-size: 1.2rem;">${element.total_restante}</span>   
                                            </div> 
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <span class="badge bg-success" style="font-size: 1.2rem;"> ${element.total_aplicadas}</span>   
                                            </div>
                                        </td>
                                    </tr>`;
                                    i++;                              
                                });
                            $('#body-reporte-data').html(tr);  
                            $('#tabla-reporte-data').removeClass('d-none');
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
                    filename:     'Reporte Progreso De Vacunas Por Campaña.pdf',
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

function seleccionar_campaniatodas(menosUno){
    let todas = 'Mostrar Todas';
    $('#campania-texto').val(todas);
    $('#campania-id-reporte').val(menosUno);
    $('#modal-campanias').modal('hide');        
}