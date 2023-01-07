<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Farmacia</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Entregadas y No Entregadas</a>
                            </li>
                            <!-- <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">No Entregadas</a>
                            </li> -->
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
                                                        <table id="tabla-citas-entregadas-no" class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Usuario Responsable</th>
                                                                    <th>Doctor</th>
                                                                    <th>Especialidad</th>
                                                                    <th>Paciente</th>
                                                                    <th>Fecha</th>
                                                                    <th>Hora</th>
                                                                    <th>Entregado</th>
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

                            <!-- <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="div" style="overflow: auto;">
                                                        <table id="tabla-entrega-receta"
                                                            class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Usuario Responsable</th>
                                                                    <th>Doctor</th>
                                                                    <th>Especialidad</th>
                                                                    <th>Paciente</th>
                                                                    <th>Fecha</th>
                                                                    <th>Hora</th>
                                                                    <th>Entregado</th>
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
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL DETALLE RECETA -->
<div class="modal fade" id="modal-receta" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Detalle</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill" id="receta-detalle">
                            <div class="card-body pt-0">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-6">
                                        <img src="<?= BASE ?>views/dist/img/Ministerio_de_Salud_Publica_de_Ecuador.png" alt="user-avatar" class="img-fluid">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card-header text-center border-bottom-0">
                                            <b>Centro de Salud "Jose Garces"</b>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-primary d-flex justify-content-center"> <b>DATOS DEL DOCTOR</b>
                                </small>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Doctor: <span id="doctor-receta"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Especialidad: <span id="especialidad-receta"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <small class="text-primary d-flex justify-content-center"> <b>DATOS DEL PACIENTE</b>
                                </small>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Cédula: <span id="receta-paciente-cedula"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Paciente: <span id="receta-paciente-nombre"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <small class="text-primary d-flex justify-content-center"> <b>DETALLE DE PRODUCTOS
                                        ENTREGADOS</b> </small>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="table-responsive">
                                        <div class="box-body">
                                            <table id="detalles" class="table table-bordered text-center">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th class="all">#</th>
                                                        <th class="all">Producto</th>
                                                        <th class="min-desktop">Cantidad</th>
                                                        <th class="min-desktop">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list-detalle">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <main class="text-right">
                    <button class="btn btn-outline-primary" id="btn-imprimir">
                        <i class="fas fa-print mr-2"></i>
                        Descargar PDF
                    </button>
                </main>
            </div>
        </div>
    </div>
</div>


<!-- MODAL SATISFACCCION PACIENTE -->
<div class="modal fade" id="modal-satisfaccion" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Calificación de la Atención</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill" id="receta-detalle">
                            <div class="card-body pt-0">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-6">
                                        <img src="<?= BASE ?>views/dist/img/Ministerio_de_Salud_Publica_de_Ecuador.png" alt="user-avatar" class="img-fluid">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card-header text-center border-bottom-0">
                                            <b>Centro de Salud "Jose Garces"</b>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-primary text-uppercase d-flex justify-content-center mt-3">
                                    <b style="font-size: 1.33em;">Califique el servicio brindado</b>
                                </span>
                                <hr class="bg-primary" style="margin: 0;">
                                <span class="text-success d-flex justify-content-center text-center" style="font-size: 1.5em; font-weight: 600;">
                                    ¿Cuál es el nivel de satisfacción de los servicios brindados?
                                </span>
                                <div class="row mt-2" id="valoracion">
                                </div>
                                <input type="hidden" id="valor">
                            </div>
                        </div>
                    </div>
                </div>

                <main class="text-right">
                    <button class="btn btn-outline-primary" id="btn-guardarSas">
                        <i class="fas fa-save mr-2"></i>
                        Guardar
                    </button>
                </main>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE ?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?= BASE ?>views/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= BASE ?>views/plugins/html2pdf/html2pdf.bundle.js"></script>

<script src="<?= BASE ?>views/dist/js/scripts/entregaReceta.js?ver=1.1.1.7"></script>