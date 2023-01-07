<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <b>Reporte Productos Más Entregados Por Receta</b> </h1>
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
                                <label>Limite</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-rotate"></i></span>
                                    </div>
                                    <select id="limite" class="form-control form-control-sm">
                                        <option value="0">Seleccione un limite</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
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
                                        <h6>Productos Más Entregados Por Receta</h6>
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
                                    <div class="col-12 text-center">
                                        <div class="mt-3">
                                            <div class="card">
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr class="bg-light">
                                                                <th>#</th>
                                                                <th>Nombre de Producto</th>
                                                                <th>Cantidad Entregada</th>
                                                                <th>Código</th>
                                                                <th>Imagen</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="body-reporte-data">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-8">
                                    <h3 class="card-title"><b>Cantidad de Productos mas Entregados</b></h3>
                                    <div id="canvas1" class="w-10 d-flex justify-content-center"> </div>
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

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/reporteProductoMasEntregado.js?ver=1.1.1.3"></script>