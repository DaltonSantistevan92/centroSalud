$(function(){

    _init();

    function _init(){
        cargarData();
        imprimir();
    }

    function cargarData(){
        $('#btn-consulta').click(function(){
            
            let fecha_inicio = $('#fecha-inicio-r-m').val();
            let fecha_fin = $('#fecha-fin-r-m').val();
            let temporalidad = $('#temporalidad option:selected').val();

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
            if(temporalidad == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione una Temporalidad'
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
                    url : urlServidor + 'citas/regresionLineal/' + fecha_inicio + '/' + fecha_fin + '/' + temporalidad,
                    // especifica si será una petición POST o GET
                    type : 'GET',
                    // el tipo de información que se espera de respuesta
                    dataType : 'json',
                    success : function(response) { 
                        if(response.data){
                            let tr = '';

                            let tabla = response.data;
                            let puntos = response.data.puntos; 
                            let total = 0;

                            for(let i = 0; i < tabla.datos.length; i++){
                                tr += `
                                <tr>
                                    <td>${i+1}</td>
                                    <td>${tabla.fechaCita[i]}</td>
                                    <td>${tabla.fechaRecetaEntregado[i]}</td>
                                    <td>${tabla.datos[i]}</td>
                                </tr>`;
                            }

                            //Realizar proyeccion 
                            if(temporalidad == 1)   textTemporalidad = 'Siguiente día';
                            else
                            if(temporalidad == 2)   textTemporalidad = 'Siguiente mes';
                            else
                            if(temporalidad == 3)   textTemporalidad = 'Siguiente año';

                            let proy = puntos.proyeccion.y;
                            let proyf = proy.toFixed(3);
                            trProyeccion = `
                                <tr class="text-white fw-bold" style="background-color: #007bff;">
                                    <td>${puntos.proyeccion.x}</td>
                                    <td>${textTemporalidad}</td>
                                    <td>Proyección: ${proyf}</td>
                                    <td>Total Productos Entregados: ${puntos.proyeccion.total_producto_entregado}</td>
                                </tr>`;

                            Highcharts.chart('regresion-lineal', {
                                title: {
                                    text: 'Gráfica de regresión lineal'
                                },
                                xAxis: {
                                    min: -0.5,
                                    max: 5.5
                                },
                                yAxis: {
                                    min: 0
                                },
                                series: [{
                                    type: 'line',
                                    name: 'Regresión lineal',
                                    data: [[puntos.inicio.x , puntos.inicio.y ], 
                                    [ puntos.fin.x , puntos.fin.y ]],
                                    marker: {
                                        enabled: false
                                    },
                                    states: {
                                        hover: {
                                            lineWidth: 0
                                        }
                                    },
                                    enableMouseTracking: false
                                }, {
                                    type: 'scatter',
                                    name: 'Puntos de dispersión',
                                    data: response.data.datos,
                                    marker: {
                                        radius: 4
                                    }
                                }]
                            });               

                            $('#proyeccion').html(tr + trProyeccion);  
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

            let data = $('#proyeccion tr');
            if (data.length == 0) {
                Toast.fire({
                    icon: 'info',
                    title: 'No hay información disponible en la tabla'
                })
            } else {
                let element = document.getElementById('tabla-reporte-data');
    
                    let opt = {
                    margin:       0.5,
                    filename:     'Regresión Lineal.pdf',
                    image:        { type: 'jpeg', quality: 3 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'in', format: 'ledger', orientation: 'portrait' }
                    };
                    html2pdf().set(opt).from(element).save();
            }
        });
    }
});