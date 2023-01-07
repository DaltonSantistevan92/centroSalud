<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Proveedores</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Crear
                                    Proveedores</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Listar
                                    Proveedores</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <form id="formulario-proveedor" type="POST">
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="">Ruc</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-r"></i></span>
                                                </div>
                                                <input type="text" class="form-control soloNumeros" placeholder="Ruc"
                                                    id="ruc-prov" name="ruc" maxlength="13" minlength="13">
                                            </div>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="">Nombre Proveedor</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-user-group"></i></span>
                                                </div>
                                                <input type="text" class="form-control solo-letras"
                                                    placeholder="Nombre Proveedor" id="nombre-prov" name="nombre"
                                                    maxlength="60" minlength="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="">Telefono</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control solo-numeros"
                                                    placeholder="Telefono" id="telefono-prov" name="telefono"
                                                    maxlength="10" maxlength="10">
                                            </div>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="">Direccion</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-building-flag"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Direccion"
                                                    id="direccion-prov" maxlength="100" name="direccion">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 form-group">
                                            <label for="">Correo</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Correo"
                                                    id="correo-prov" name="correo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-outline-primary"><i
                                                class="far fa-save mr-2"></i>Guardar Registro</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="div" style="overflow: auto;">
                                                        <table id="tabla-proveedores"
                                                            class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Proveedor</th>
                                                                    <th>RUC</th>
                                                                    <th>Correo</th>
                                                                    <th>Dirección</th>
                                                                    <th>Teléfono</th>
                                                                    <th>Acciones</th>
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

<!-- MODAL EDITAR -->
<div class="modal fade" id="modal-editar-proveedor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-outline card-primary">
            <div class="modal-header">
                <h4 class="modal-title"> <b>Editar</b> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="contanier-fluid">
                    <input type="hidden" id="proveedor-id">
                    <form id="actualizar-proveedor" type="POST">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="">Ruc</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-r"></i></span>
                                    </div>
                                    <input type="text" class="form-control soloNumeros" placeholder="Ruc" id="ruc-prov-upd"
                                        name="ruc" maxlength="13" minlength="13" readOnly>
                                </div>
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Nombre Proveedor</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-user-group"></i></span>
                                    </div>
                                    <input type="text" class="form-control solo-letras" placeholder="Nombre Proveedor"
                                        id="nombre-prov-upd" name="nombre" maxlength="60" minlength="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="">Telefono</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control solo-numeros" placeholder="Telefono"
                                        id="telefono-prov-upd" name="telefono" maxlength="10" maxlength="10">
                                </div>
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Direccion</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-building-flag"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Direccion" id="direccion-prov-upd"
                                        maxlength="100" name="direccion">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="">Correo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Correo" id="correo-prov-upd"
                                        name="correo">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12 form-group text-right">
                            <button class="btn btn-outline-primary" id="btn-update" type="button">
                                <i class="fas fa-save mr-2"></i>Actualizar Registro</button>
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

<!-- jquery-validation -->
<script src="<?=BASE?>views/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?=BASE?>views/plugins/jquery-validation/additional-methods.min.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/nuevoProveedor.js?ver=1.1.1.2"></script>