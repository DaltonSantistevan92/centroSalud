<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Abastecimiento</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Nuevo
                                    Abastecimiento</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Listar
                                    Abastecimiento</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-right">
                                            <button class="btn btn-outline-dark btn-sm" data-toggle="modal"
                                                data-target="#modal-proveedores" data-backdrop="static"
                                                data-keyboard="false"><i class="fa fa-search mr-2"></i>Buscar
                                                Proveedor</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="">RUC</label>
                                                    <input type="text" class="form-control solo-letras form-control-sm"
                                                        readOnly placeholder="Nombre" id="prov-ruc">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" id="prov-id">
                                                    <label for="">Nombre Proveedor</label>
                                                    <input type="text" class="form-control solo-letras form-control-sm"
                                                        readOnly placeholder="Nombre" id="prov-nombre">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-outline-dark btn-sm" data-toggle="modal"
                                                data-target="#modal-productos" data-backdrop="static"
                                                data-keyboard="false"><i class="fa fa-search mr-2"></i>Buscar
                                                Producto</button>
                                        </div>
                                        <form method="POST" id="formulario-nuevo-abastecer">
                                            <div class="row mt-2">
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <input type="hidden" id="producto-id">
                                                        <label for="">Nombre</label>
                                                        <input type="text"
                                                            class="form-control solo-letras form-control-sm" readOnly
                                                            placeholder="Nombre" id="producto-nombre">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Categoría</label>
                                                        <input id="producto-categoria" type="text" readOnly
                                                            class="form-control form-control-sm"
                                                            placeholder="Categoría">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="form-img-usuario">Imagen</label>
                                                        <div class="row">
                                                            <img id="producto-imagen" class="mx-auto d-block"
                                                                src="<?=SERVIDOR?>resources/productos/producto_default.jpg"
                                                                style="height: 100px;width: 100px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Cantidad</label>
                                                        <input type="text"
                                                            class="form-control solo-numeros form-control-sm"
                                                            placeholder="Cantidad" id="producto-cantidad">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Stock</label>
                                                        <input type="text"
                                                            class="form-control solo-numeros form-control-sm" readOnly
                                                            placeholder="Stock" id="producto-stock">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <button id="item-agregar" class="btn btn-primary btn-sm"
                                                        style="margin-top: 30px;"><i
                                                            class="fas fa-plus mr-2"></i>Agregar Producto</button>
                                                </div>
                                            </div>

                                            <div class="row d-none" id="table-detalle-abastecer">
                                                <div class="col-12">
                                                    <div class="tabla-item-productos" style="overflow: auto;">
                                                        <table class="table table-striped table-bordered text-center">
                                                            <thead>
                                                                <tr class="bg-primary">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Descripción</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Total</th>
                                                                    <th>Borrar</th>
                                                                    <th style="display:none;">Id</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="items-productos">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer text-right">
                                                <button type="submit" class="btn btn-outline-primary"><i
                                                        class="far fa-save mr-2"></i>Guardar Registro</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="div" style="overflow: auto;">
                                                        <table id="tabla-abastecimientos"
                                                            class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Código</th>
                                                                    <th>Proveedor</th>
                                                                    <th>Productos Entregados</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Fecha</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        </table>
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
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL PROVEEDORES -->
<div class="modal fade" id="modal-proveedores">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Proveedores Disponibles</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="height: 200px !important; overflow: auto;">
                    <div class="col-12">
                        <div class="tabla-buscar-producto">
                            <table class="table table-hover text-nowrap text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="display: none">ID</th>
                                        <th>RUC</th>
                                        <th>Proveedor</th>
                                        <th>OK</th>
                                    </tr>
                                </thead>
                                <tbody id="proveedores-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>

<!-- MODAL PRODUCTOS -->
<div class="modal fade" id="modal-productos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Productos Disponibles</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="height: 200px !important; overflow: auto;">
                    <div class="col-12">
                        <div class="tabla-buscar-producto">
                            <table class="table table-hover text-nowrap text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="display: none">ID</th>
                                        <th>Producto</th>
                                        <th style="display: none">Categoría</th>
                                        <th>Stock</th>
                                        <th style="display: none">Imagen</th>
                                        <th>OK</th>
                                    </tr>
                                </thead>
                                <tbody id="productos-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>

<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/nuevoAbastecimiento.js?ver=1.1.1.2"></script>