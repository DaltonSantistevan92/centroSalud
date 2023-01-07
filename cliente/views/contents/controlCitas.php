<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Control de Citas</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1"
                                    data-toggle="tab">Pendientes</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Atendidas</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Canceladas</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="div" style="overflow: auto;">
                                                        <table id="tabla-citas-pendientes"
                                                            class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Paciente</th>
                                                                    <th>Sexo</th>
                                                                    <th>Fecha</th>
                                                                    <th>Hora</th>
                                                                    <th>Estado Cita</th>
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

                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="div" style="overflow: auto;">
                                                        <table id="tabla-citas-atendidas"
                                                            class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Paciente</th>
                                                                    <th>Sexo</th>
                                                                    <th>Fecha</th>
                                                                    <th>Hora</th>
                                                                    <th>Estado Cita</th>
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

                            <div class="tab-pane" id="tab_3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="div" style="overflow: auto;">
                                                        <table id="tabla-citas-canceladas"
                                                            class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Paciente</th>
                                                                    <th>Sexo</th>
                                                                    <th>Fecha</th>
                                                                    <th>Hora</th>
                                                                    <th>Estado Cita</th>
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
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL RECETA -->
<div class="modal fade" id="modal-receta" style="overflow-y: scroll;">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" id="cita_id">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Receta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <span class="h5">
                            <b>Paciente:</b>
                            <span id="receta-nombre-paciente"> Jose </span>
                        </span>
                    </div>
                    <div class="col-12 col-md-6">
                        <span class="h5">
                            <b>Fecha:</b>
                            <span id="receta-fecha">
                                <?php echo(date('d-m-Y'));?>
                            </span>
                        </span>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label>RX:</label>
                            <textarea id="receta-descripcion" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modal-productos"
                            data-backdrop="static" data-keyboard="false"><i class="fas fa-search mr-2"></i> Agregar
                            Producto</button>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 col-md-5">
                        <input type="hidden" id="producto-id">
                        <div class="form-group">
                            <label for="">Producto</label>
                            <input id="producto-nombre" type="text" readOnly class="form-control form-control-sm"
                                placeholder="Producto">
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="form-group">
                            <label for="">Stock</label>
                            <input id="producto-stock" type="text" readOnly class="form-control form-control-sm"
                                placeholder="Stock">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">Cantidad</label>
                            <input id="producto-cantidad" type="text" class="form-control form-control-sm solo-numeros"
                                placeholder="Cantidad">
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <button id="agregar-producto" class="btn btn-dark btn-sm" style="margin-top: 30px;"><i
                                class="fas fa-plus"></i></button>
                        <!-- <button id="btn-borrar" class="btn btn-primary btn-sm" style="margin-top: 30px;"><i
                                class="fas fa-minus"></i></button> -->
                    </div>
                </div>

                <div class="row mt-2 d-none" id="table-detalle-receta">
                    <div class="table-responsive">
                        <div class="box-header">
                            <h5 class="box-title"><b>Detalle de la Receta</b></h5>
                        </div>
                        <div class="box-body">
                            <table id="detalles" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="all">#</th>
                                        <th class="all">Producto</th>
                                        <th class="min-desktop">Cantidad</th>
                                        <th class="min-desktop">Total</th>
                                        <th class="min-desktop">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listProdReceta">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-2">
                    <button class="btn btn-outline-primary" id="guardar-receta"><i
                            class="fas fa-save mr-2"></i>Guardar Receta</button>
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
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="busqueda">Buscar Producto</label>
                            <input type="text" class="form-control" placeholder="Ingrese el nombre del producto" id="busqueda">
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 200px !important; overflow: auto;">
                    <div class="col-12">
                        <div class="tabla-buscar-producto">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="display: none">ID</th>
                                        <th>Producto</th>
                                        <th>Stock</th>
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

<!-- MODAL CITAS -->
<div class="modal fade" id="modal-verCita">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Cita Detalle</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-center border-bottom-0">
                                <b>Centro de Salud "Jose Garces"</b>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b>Doctor(a): <span id="cita-doctor-m"></span> </b></h2>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"><i
                                                        class="fas fa-lg fa-building"></i></span> Especialidad: <span
                                                    id="cita-espe-m"></span>
                                            </li>
                                            <li class="medium"><span class="fa-li"><i
                                                        class="fa-solid fa-clipboard-user"></i></span> Paciente: <span
                                                    id="cita-paciente-m"></span>
                                            </li>
                                            <li class="medium"><span class="fa-li"><i
                                                        class="fas fa-calendar-alt"></i></span> Fecha: <span
                                                    id="cita-fecha-m"></span></li>
                                            <li class="medium"><span class="fa-li"><i class="fas fa-clock"></i></span>
                                                Hora: <span id="cita-hora-m"></span></li>
                                            <li class="medium"><span class="fa-li"><i
                                                        class="fas fa-sticky-note"></i></span>
                                                Estado: <span id="cita-estado-m"></span></li>
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="<?=BASE?>views/dist/img/cita-logo.jpg" alt="user-avatar"
                                            class="img-circle img-fluid">
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

<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="<?=BASE?>views/dist/js/scripts/controlCitas.js?ver=1.1.1.5"></script>