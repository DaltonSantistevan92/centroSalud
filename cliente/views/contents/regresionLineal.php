<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <b>Proyección de Productos Entregados Por Citas</b> </h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-danger shadow-lg">
                    <div class="card-body">
                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-6 col-md-4 col-lg-3 form-group">
                                <label>Fecha Inicio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                                    </div>
                                    <input id="fecha-inicio-r-m" type="date" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3 form-group">
                                <label>Fecha fin</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                                    </div>
                                    <input id="fecha-fin-r-m" type="date" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3 form-group">
                                <label>Temporalidades</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-rotate"></i></span>
                                    </div>
                                    <select id="temporalidad" class="form-control form-control-sm">
                                        <option value="0">Selecione una Temporalidad</option>
                                        <option value="1">Dia</option>
                                        <option value="2">Mes</option>
                                        <option value="3">Año</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-3 form-group ">
                                <button class="btn btn-outline-dark btn-sm " id="btn-consulta"
                                    style="margin-top: 35px;">
                                    <i class=" fa fa-search mr-2"></i> Consultar</button>
                                <button class="btn btn-outline-primary btn-sm " id="btn-imprimir"
                                    style="margin-top: 35px;">
                                    <i class="far fa-file-pdf mr-2"></i> Imprimir</button>
                            </div>
                        </div>

                        <div class="row d-none" id="tabla-reporte-data">
                            <div class="col-12 mt-2">
                                <div class="row">
                                    <div class="col-6 col-md-8 col-lg-9" style="padding-left: 60px">
                                        <h3><b>CENTRO DE SALUD "JOSE GARCES"</b></h3>
                                        <h6>Proyección de Productos Entregados Por Citas</h6>
                                        <h6 class="text-danger">Desde:
                                            <span class="text-dark" id="fecha-inicio-r-m2"></span> - Hasta:
                                            <span class="text-dark" id="fecha-fin-r-m2"></span>
                                        </h6>
                                    </div>
                                    <div class="col-6-col-md-4 col-lg-3">
                                        <img src="<?=BASE?>views/dist/img/Ministerio_de_Salud_Publica_de_Ecuador.png"
                                            width="260px" style="margin-left: -130px;">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <small><b>Fecha de Consulta: <span id="fecha-consulta-s"></span></b></small>
                                    <small><b>Hora de Consulta: <span id="hora-consulta-s"></span></b></small>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-12 col-md-6 text-center">
                                        <div class="mt-3">
                                            <div class="card card-primary shadow-lg">
                                                <div class="card-header">
                                                    <h5>Tabla de Datos</h5>
                                                </div>
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr class="bg-light">
                                                                <th>#</th>
                                                                <th>Fecha Cita</th>
                                                                <th>Fecha Entrega Producto</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="proyeccion">

                                                        </tbody>
                                                    </table>
                                                    <input type="hidden" id="const-a">
                                                    <input type="hidden" id="const-b">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12 col-md-6 text-center">
                                        <div class="mt-3">
                                            <div class="card card-primary shadow-lg">
                                                <div class="card-header">
                                                    <h5>Gráfica</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div id="regresion-lineal"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=BASE?>views/plugins/html2pdf/html2pdf.bundle.js"></script>
    <script src="<?=BASE?>views/plugins/chart.js/Chart.min.js"></script>
    <script src="<?=BASE?>views/plugins/higchart/highcharts.js"></script>
    <script src="<?=BASE?>views/plugins/higchart/modules/exporting.js"></script>
    <script src="<?=BASE?>views/plugins/higchart/modules/export-data.js"></script>
    <script src="<?=BASE?>views/plugins/higchart/modules/accessibility.js"></script>

    <script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
    <script src="<?=BASE?>views/dist/js/scripts/regresionLineal.js?ver=1.1.1.5"></script>