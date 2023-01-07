<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Inventario de Productos</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1"
                                    data-toggle="tab">Inventario</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">

                                <div class="row d-flex justify-content-center">
                                    <div class="col-6 col-md-4 col-lg-3 form group">
                                        <label>Categoría</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-tags"></i></span>
                                            </div>
                                            <select class="form-control" id="select-categoria">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-4 form group">
                                        <label>Producto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                                            </div>
                                            <select class="form-control" id="select-productos">
                                                 <option>Seleccione un Producto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4 col-lg-3 form group">
                                        <button class="btn btn-outline-dark" id="btn-consultar"
                                            style="margin-top: 31px;"><i class="fas fa-play mr-2"></i>Consultar</button>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="div" style="overflow: auto;">
                                                <table id="tabla-inventario"
                                                    class="table table-bordered table-hover table-sm text-center d-none">
                                                    <thead>
                                                        <tr class="bg-primary">
                                                            <th rowspan="2" class="text-center">N°</th>
                                                            <th rowspan="2" class="text-center">Fecha</th>
                                                            <th rowspan="2" class="text-center">Movimiento</th>
                                                            <th colspan="1" class="text-center">Entradas</th>
                                                            <th colspan="1" class="text-center">Salidas</th>
                                                            <th colspan="1" class="text-center">Disponibles</th>
                                                        </tr>
                                                        <tr class="bg-primary">
                                                            <th class="text-center">Cantidad de Entrada</th>
                                                            <th class="text-center">Cantidad de Salida</th>
                                                            <th class="text-center">Cantidad Disponibles</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/verInventario.js"></script>