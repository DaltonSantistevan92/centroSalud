<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row col-xs-12 d-flex justify-content-between">
            <div class="col-12 col-md-4 mt-3">
                <a class="btn btn-outline-primary form-control" href="<?= BASE ?>aplicacion/vacuna">
                    <i class="fa-solid fa-syringe"></i>
                    Aplicar Vacuna
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Pacientes</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Crear
                                    Pacientes</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Listar
                                    Pacientes</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <form id="form-datos-paciente" method="POST">
                                    <div class="row">
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Cédula</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-c"></i></span>
                                                </div>
                                                <input id="new-cedula" type="text" name="cedula"
                                                    class="form-control solo-numeros" maxlength="10" minlength="10">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Nombre</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-address-card"></i></span>
                                                </div>
                                                <input id="new-nombre" type="text" name="nombre"
                                                    class="form-control solo-letras" maxlength="50" minlength="3">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Apellido</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-id-card"></i></span>
                                                </div>
                                                <input id="new-apellido" type="text" name="apellido"
                                                    class="form-control solo-letras" maxlength="50" minlength="3">
                                            </div>

                                        </div>
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Celular #</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-mobile-screen"></i></span>
                                                </div>
                                                <input id="new-celular" type="text" name="celular"
                                                    class="form-control solo-numeros" maxlength="10" minlength="10">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Direccion</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-building-flag"></i></span>
                                                </div>
                                                <input id="new-direccion" type="text" name="direccion"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Sexo</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-venus-mars"></i></span>
                                                </div>
                                                <select name="sexo" id="new-sexo" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-outline-primary" type="submit"><i
                                                    class="fas fa-save mr-2"></i>Guardar Registro</button>
                                        </div>
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
                                                        <table id="tabla-pacientes"
                                                            class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Cedula</th>
                                                                    <th>Nombre</th>
                                                                    <th>Apellido</th>
                                                                    <th># Celular</th>
                                                                    <th>Direccion</th>
                                                                    <th>Sexo</th>
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
<div class="modal fade" id="modal-editar-paciente">
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
                    <form id="actualizar-usuario" method="POST">
                        <div class="row ">
                            <div class="col-12 col-md-4 form-group">
                                <input type="hidden" id="paciente-id">
                                <input type="hidden" id="persona-id">
                                <label for="">Cédula</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-c"></i></span>
                                    </div>
                                    <input id="upd-cedula" type="text" name="cedula" class="form-control solo-numeros"
                                        maxlength="10" minlength="10" readOnly>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-address-card"></i></span>
                                    </div>
                                    <input id="upd-nombre" type="text" name="nombre" class="form-control solo-letras"
                                        maxlength="50" minlength="3">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Apellido</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                                    </div>
                                    <input id="upd-apellido" type="text" name="apellido"
                                        class="form-control solo-letras" maxlength="50" minlength="3">
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Celular #</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-mobile-screen"></i></span>
                                    </div>
                                    <input id="upd-celular" type="text" name="celular" class="form-control solo-numeros"
                                        maxlength="10" minlength="10">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Direccion</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-building-flag"></i></span>
                                    </div>
                                    <input id="upd-direccion" type="text" name="direccion" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Sexo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-venus-mars"></i></span>
                                    </div>
                                    <select name="" id="upd-sexo" class="form-control">
                                    </select>
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
<script src="<?=BASE?>views/dist/js/scripts/pacienteVacuna.js"></script>