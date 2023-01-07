$(function(){

    _init();

    function _init(){
        cargarGrafica1();
        cargarGrafico2();
        cargarGrafico3();
        cargandoData();
    }

    function cargarGrafica1(){
        $.ajax({
            url: urlServidor + 'estado_cita/variosEstados',
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
                    let donutData = {
                        labels: response.datos.labels,
                        datasets: [
                            {
                                data: response.datos.data,
                                backgroundColor: ['#dc3545', '#00a65a', '#adb5bd', '#17a2b8'],
                            }
                        ]
                    }

                    var pieChartCanvas = $('#canvas1').get(0).getContext('2d')
                    var pieData = donutData;
                    var pieOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                    }
                    
                    new Chart(pieChartCanvas, {
                        type: 'pie',
                        data: pieData,
                        options: pieOptions
                    })
                } else {
                    Toast.fire({
                        icon: 'info',
                        title: 'No hay informacion disponible'
                    })
                }
            }
        });
    }

    function cargarGrafico2() {
        $.ajax({
            url: urlServidor + 'categorias/grafico',
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
                    new Chart(document.getElementById("canvas2"), {
                        type: 'bar',
                        data: {
                            labels: response.datos.labels,
                            datasets: [
                                {
                                    label: "Total",
                                    backgroundColor: ["#fe0612", "#fff706", "#282f34", "#009000", "#adb5bd", "#007bff", "#dc3545", "#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                    data: response.datos.data
                                }
                            ]
                        },
                        options: {
                            legend: { display: false },
                        }
                    });
                } else {
                    Toast.fire({
                        icon: 'info',
                        title: 'No hay informacion disponible'
                    })
                }
            }
        });
    }

    function cargarGrafico3() {
        $.ajax({
            url: urlServidor + 'productos/graficoStockProductos',
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
                    new Chart(document.getElementById("canvas3"), {
                        type: 'bar',
                        data: {
                            labels: response.datos.labels,
                            datasets: [
                                {
                                    label: "Stock",
                                    backgroundColor: ["#007bff", "#28a745", "#ffc107", "#009000", "#fff706", "#fe0612", "#282f34", "#009000", "#fff706", "#fe0612", "#282f34", "#009000"],
                                    data: response.datos.data
                                }
                            ]
                        },
                        options: {
                            legend: { display: false },
                        }
                    });
                } else {
                    Toast.fire({
                        icon: 'info',
                        title: 'No hay informacion disponible'
                    })
                }
            }
        });
    }

    function cargandoData() {
        cantidadUsuarios();
        function cantidadUsuarios() {
            $.ajax({
                url: urlServidor + 'usuarios/contar',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#cantidad-usuarios').text(response.cantidad);
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

        cantidadPacientes();
        function cantidadPacientes() {
            $.ajax({
                url: urlServidor + 'pacientes/contar',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#cantidad-pacientes').text(response.cantidad);
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

        cantidadProductos();
        function cantidadProductos() {
            $.ajax({
                url: urlServidor + 'productos/contar',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#cantidad-productos').text(response.cantidad);
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

        cantidadDoctores();
        function cantidadDoctores() {
            $.ajax({
                url: urlServidor + 'doctores/contar',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#cantidad-doctores').text(response.cantidad);
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

        cantidadCitasPendidas();
        function cantidadCitasPendidas() {
            $.ajax({
                url: urlServidor + 'citas/pendienteContar',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#cantidad-pendientes').text(response.cantidad);
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

        cantidadCitasAtendidas();
        function cantidadCitasAtendidas() {
            $.ajax({
                url: urlServidor + 'citas/atendidaContar',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#cantidad-atendidas').text(response.cantidad);
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
    }
});