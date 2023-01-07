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
            let limite = $('#limite option:selected').val();

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
                    url : urlServidor + 'recetas/productoMasEntregado/' + fecha_inicio + '/' + fecha_fin + '/' + limite,
                    // especifica si será una petición POST o GET
                    type : 'GET',
                    // el tipo de información que se espera de respuesta
                    dataType : 'json',
                    success : function(response) { 
                        console.log(response);
                        if(response.status){
                            let tr = '';
                            let i = 1;

                            response.lista_receta.forEach(element => {
                                let img = urlServidor + 'resources/productos/' + element.producto.imagen ;  
                                tr += `<tr>
                                        <th>${i}</th>
                                        <th>${element.producto.nombre}</th>
                                        <th>${element.cantidad}</th>
                                        <th>${element.producto.codigo}</th>
                                        <th>
                                            <img class="mx-auto d-block"
                                            src=${img} style="height: 60px;width: 60px;">
                                        </th> 
                                    </tr>`;
                                i++;                             
                            });
                            $('#body-reporte-data').html(tr);  
                            $('#tabla-reporte-data').removeClass('d-none');

                             /* Canvas Dashboard */
                            $('#canvas1').html('');
                            let canvas1 = `<canvas id="box-barra1" style="min-height: 300px; height: 300px; 
                                                    max-height: 300px; max-width: 100%; margin-top:22px">
                                        </canvas>`;
                            $('#canvas1').html(canvas1);

                            let areaChartData = {
                                labels : response.data_receta.labels_receta,
                                datasets: [
                                    {
                                        label: 'Cantidad',
                                        backgroundColor : ['#109dfA  ','#FF0000','#FFDE00','#008f39','#ef280f','#e7d40a'],
                                        pointRadius: false,
                                        pointColor: '#3b8bba',
                                        pointStrokeColor : 'rgba(60,141,188,1)',
                                        pointHighlightFill: '#fff',
                                        pointHighlightStroke: 'rgba(60,141,188,1)',
                                        data : response.data_receta.masEntregadosxReceta
                                    },  
                                ]
                            }

                            var barChartCanvas = $('#box-barra1').get(0).getContext('2d');
                            var barChartData = $.extend(true, {}, areaChartData);
                            var temp0 = areaChartData.datasets[0];
                            areaChartData.datasets[0] = temp0;
                    
                            var barChartOptions = {
                                responsive : true,
                                maintainAspectRadio : false,
                                datasetFill : false
                            }

                            new Chart(barChartCanvas,{
                                type: 'pie',
                                data: barChartData,
                                options: barChartOptions
                            });

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
                    filename:     'Reporte Productos Más Entregados Por Receta.pdf',
                    image:        { type: 'jpeg', quality: 3 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'in', format: 'ledger', orientation: 'portrait' }
                    };
                    html2pdf().set(opt).from(element).save();
            }
        });
    }
});