<div class="content">
    <div class="container-fluid">
        <div class="row col-xs-12 d-flex justify-content-between">
            <div class="col-12 col-md-3 mt-2">
                <a class="btn btn-outline-primary form-control" href="<?= BASE ?>paciente/pacienteVacuna">
                    <i class="fa-solid fa-clipboard-user mr-2"></i>
                    Nuevo Paciente
                </a>
            </div>
            <div class="col-12 col-md-3 mt-2">
                <a class="btn btn-outline-dark form-control" id="btn-desocupar">
                    <i class="fa-solid fa-comment-medical mr-2"></i>
                    Desocuparme
                </a>
            </div>
        </div>

        <div class="row mt-2 d-flex justify-content-center">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1">
                        <i class="fa-solid fa-syringe"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total de Vacunas</span>
                        <span class="info-box-number text-center" id="total-vacunas-text"> </span>
                        <input id="total-vacunas" type="hidden" class="form-control" readOnly>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1">
                        <i class="fa-solid fa-syringe"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Vacunas Restantes</span>
                        <span id="vacunas-restante" class="info-box-number text-center"></span>
                        <!-- <input id="total-restante-val" type="hidden" class="form-control" readOnly> -->
                    </div>
                </div>
            </div>

            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1">
                        <i class="fa-solid fa-syringe"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Vacunas Aplicadas</span>
                        <span id="vacunas-aplicada" class="info-box-number text-center">0</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-2">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Aplicación de Vacunas</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab_1" data-toggle="tab">Aplicar Vacuna</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab_2" data-toggle="tab">Listado de Pacientes Vacunados</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <medium class="text-primary"> <b>DATOS DEL ENFERMERO Y CAMPAÑA</b> </medium>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-3 form-group">
                                        <label for="">Centro de Salud</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-hospital"></i>
                                                </span>
                                            </div>
                                            <input id="new-nombre" type="text" name="nombre"
                                                class="form-control form-control-sm" value="Centro de Salud Jose Garces"
                                                readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 form-group">
                                        <input type="hidden" id="enfermero_id">
                                        <label for="">Nombre del Enfermero</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-user-doctor"></i>
                                                </span>
                                            </div>
                                            <input id="enfermero-nombre" type="text"
                                                class="form-control form-control-sm" readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 form-group">
                                        <input type="hidden" id="campania_id">
                                        <label for="">Nombre Campaña</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-tents"></i>
                                                </span>
                                            </div>
                                            <input id="campania-nombres" type="text"
                                                class="form-control form-control-sm" readOnly>
                                        </div>
                                    </div>
                                </div>

                                <medium class="text-primary"> <b>UBICACION DE LA CAMPAÑA - INTERVALO DE EDAD - FECHA
                                        CAMPAÑA</b> </medium>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-2 form-group">
                                        <label for="">Provincia</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-p"></i></span>
                                            </div>
                                            <input id="provincia" type="text" class="form-control form-control-sm"
                                                readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 form-group">
                                        <label for="">Canton</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-c"></i></span>
                                            </div>
                                            <input id="canton" type="text" class="form-control form-control-sm"
                                                readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 form-group">
                                        <label for="">Parroquia</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-light fa-p"></i></span>
                                            </div>
                                            <input id="parroquia" type="text" class="form-control form-control-sm"
                                                readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 form-group">
                                        <label for="">Barrio</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa-solid fa-location-arrow"></i></span>
                                            </div>
                                            <input id="barrio" type="text" class="form-control form-control-sm"
                                                readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 form-group">
                                        <label for="">Intervalo de Edad</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa-solid fa-location-arrow"></i></span>
                                            </div>
                                            <input id="edad" type="text" class="form-control form-control-sm" readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 form-group">
                                        <label for="">Fecha
                                            <span id="fecha" class=" badge badge-primary info-box-text"> </span>
                                            y Hora
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-clock"></i>
                                                </span>
                                            </div>
                                            <input id="hora" type="time" name="hora"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>

                                <medium class="text-primary"> <b>DATOS DEL PACIENTE</b> </medium>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-2">
                                        <input type="hidden" id="paciente-id">
                                        <div class="form-group">
                                            <label for="">Cedula</label>
                                            <input id="paciente-cedula" type="text" readOnly
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <input type="hidden" id="prod-id">
                                        <div class="form-group">
                                            <label for="">Nombre</label>
                                            <input id="paciente-nombre" type="text" readOnly
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="">Apellido</label>
                                            <input id="paciente-apellido" type="text" readOnly
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="">Num Celular</label>
                                            <input id="paciente-celular" type="text"
                                                class="form-control form-control-sm solo-numeros" readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="">Sexo</label>
                                            <input id="paciente-sexo" type="text" class="form-control form-control-sm"
                                                readOnly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <button style="margin-top: 31px;"
                                                class="btn btn-outline-dark btn-sm mb-3 float-right" data-toggle="modal"
                                                data-target="#modal-paciente" data-backdrop="static"
                                                data-keyboard="false">
                                                <i class="fas fa-search mr-2"></i>Buscar Paciente
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <medium class="text-primary"> <b>Aplicar</b> </medium>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label for="">Nombre de la Vacuna</label>
                                            <input id="nombre-vacuna" type="text" readOnly
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <input type="hidden" id="paciente-id">
                                        <div class="form-group">
                                            <label for="">Dosis</label>
                                            <input id="dosis" value="1" type="text" readOnly
                                                class="form-control form-control-sm solo-numeros">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-8 text-right">
                                        <button id="btn-vacunar" style="margin-top: 28px;"
                                            class="btn btn-outline-primary btn-sm" type="button">
                                            <i class="fa-solid fa-syringe"></i>
                                            Vacunar
                                        </button>
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
                                                        <table id="tabla-vacunas"
                                                            class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Campaña</th>
                                                                    <th>Paciente</th>
                                                                    <th>Nombre Vacuna</th>
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
    </div>
</div>

<!-- MODAL PACIENTE -->
<div class="modal fade" id="modal-paciente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Pacientes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="buscar-paciente">Buscar Pacientes</label>
                            <input id="buscar-paciente" type="text" class="form-control"
                                placeholder="Ingrese cedula o nombre del paciente a buscar">
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 200px !important; overflow: auto;">
                    <div class="col-12">
                        <div class="tabla-buscar-paciente">
                            <table class="table table-hover table-bordered text-nowrap text-center">
                                <thead>
                                    <tr class="bg-light">
                                        <th>#</th>
                                        <th style="display: none">ID</th>
                                        <th>Cedula</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Num Celular</th>
                                        <th>Sexo</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody id="paciente-body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
            </div>
        </div>
    </div>
</div>

<!-- MODAL CITAS -->
<div class="modal fade" id="modal-verCarnet" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Carnet de Vacunacion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-body pt-0">
                                <div class="row mt-2">
                                    <div class="col-12 col-md-6">
                                        <img src="<?=BASE?>views/dist/img/Ministerio_de_Salud_Publica_de_Ecuador.png"
                                            alt="user-avatar" class="img-fluid">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card-header text-center border-bottom-0">
                                            <b>Centro de Salud "Jose Garces"</b>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-primary"> <b>DATOS DE LA CAMPAÑA</b> </small>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Canton: <span
                                                    id="vacuna-canton"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Barrio: <span
                                                    id="vacuna-barrio"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Intervalo de Edad: <span
                                                    id="cita-edad"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <small class="text-primary"> <b>DATOS DEL PACIENTE</b> </small>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Cedula: <span
                                                    id="vacuna-paciente-cedula"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Paciente: <span
                                                    id="vacuna-paciente-nombre"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span># Celular: <span
                                                    id="vacuna-paciente-celular"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <small class="text-primary"> <b>VACUNA</b> </small>
                                <hr class="bg-primary" style="margin: 0;">
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Vacuna: <span
                                                    id="vacuna-nombre"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul class="ml-2 mb-0 fa-ul text-muted">
                                            <li class="medium"><span class="fa-li"></span> Dosis: <span
                                                    id="vacuna-dosis"></span>
                                            </li>
                                        </ul>
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

<script src="<?=BASE?>views/dist/js/scripts/nuevaVacuna2.js?ver=1.1.1.3"></script>
<!-- <script src="<?=BASE?>views/dist/js/scripts/nuevaVacuna.js?ver=1.1.1"></script> -->