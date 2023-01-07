<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Gestión de Citas</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Crear
                                    Citas</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Listar Citas</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <!-- <form id="form-datos-citas" method="POST"> -->
                                <div class="row col-xs-12 d-flex justify-content-between">
                                    <div class="col-12 col-md-3">
                                        <a class="btn btn-outline-primary form-control" href="<?= BASE ?>cita/paciente"
                                            data-backdrop="static" data-keyboard="false">
                                            <i class="fa-solid fa-clipboard-user mr-2"></i>
                                            Nuevo Paciente
                                        </a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">

                                        <hr class="bg-dark">

                                        <div class="row d-flex">
                                            <div class="col-12 col-md-8 form-group">
                                                <input type="hidden" id="doctor-id">
                                                <label for="">Dr(a)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-user-md"></i></span>
                                                    </div>
                                                    <input id="nombre-doctor" type="text" name="nombre"
                                                        class="form-control solo-letras" maxlength="50" minlength="3"
                                                        readOnly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 text-right">
                                                <button class="btn btn-outline-dark mb-2 ml-1" style="margin-top: 31px;"
                                                    data-toggle="modal" data-target="#modal-doctores"
                                                    data-backdrop="static" data-keyboard="false"><i
                                                        class="fas fa-search"></i> Buscar
                                                    Doctor</button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <input type="hidden" id="especialidad-id">
                                                <label for="">Especialidad</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa-solid fa-notes-medical"></i></span>
                                                    </div>
                                                    <input id="espe-cita" type="text" name="nombre"
                                                        class="form-control solo-letras" maxlength="50" minlength="3"
                                                        readOnly>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="bg-dark">

                                        <div class="row">
                                            <div class="col-12 col-md-4 form-group">
                                                <input type="hidden" id="paciente-id">
                                                <label for="">Cedula</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa-solid fa-c"></i></span>
                                                    </div>
                                                    <input id="cedula-paciente" type="text" name="nombre"
                                                        class="form-control solo-letras" maxlength="10" minlength="3"
                                                        readOnly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 form-group">
                                                <input type="hidden" id="paciente-id">
                                                <label for="">Pacientes</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-user-tag"></i></span>
                                                    </div>
                                                    <input id="nombre-paciente" type="text" name="nombre"
                                                        class="form-control solo-letras" maxlength="50" minlength="3"
                                                        readOnly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 text-right">
                                                <button class="btn btn-outline-dark mb-2 ml-1" style="margin-top: 31px;"
                                                    data-toggle="modal" data-target="#modal-pacientes"
                                                    data-backdrop="static" data-keyboard="false"><i
                                                        class="fas fa-search"></i> Buscar
                                                    Paciente</button>
                                            </div>
                                        </div>

                                        <hr class="bg-dark">

                                        <div class="row">
                                            <div class="col-12 col-md-6 form-group">
                                                <label for="">Fecha</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input id="fecha-hor" type="text" name="nombre"
                                                        class="form-control solo-letras" maxlength="50" minlength="3"
                                                        readOnly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 form-group">
                                                <label for="">Horario</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-clock"></i></span>
                                                    </div>
                                                    <input id="horario-texto" type="text" name="nombre"
                                                        class="form-control solo-letras" maxlength="50" minlength="3"
                                                        readOnly>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="bg-dark">

                                        <div class="row mt-2">
                                            <div class="col-12 text-center">
                                                <button class="btn btn-outline-primary" id="btn-guardar-cita"><i
                                                        class="fa-solid fa-calendar-check mr-2"></i>Guardar
                                                    Cita</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <!-- THE CALENDAR -->
                                        <div id="calendar"></div>
                                    </div>
                                </div>

                                <!-- </form> -->
                            </div>

                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="div" style="overflow: auto;">
                                                        <table id="tabla-citas"
                                                            class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Usuario Responsable</th>
                                                                    <th>Doctor(a)</th>
                                                                    <th>Especialidad</th>
                                                                    <th>Paciente</th>
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
    </div>
</div>

<!-- Modal Doctor -->
<div class="modal fade" id="modal-doctores">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Doctores Disponibles</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="height: 200px !important; overflow: auto;">
                    <div class="col-12">
                        <div class="tabla-buscar-mascota">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="display: none">ID</th>
                                        <th>Nombres</th>
                                        <th>OK</th>
                                    </tr>
                                </thead>
                                <tbody id="doctor-body">

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

<!-- MODAL HORARIOS -->
<div class="modal fade" id="modal-lista-horario-disponible">
    <div class="modal-dialog">
        <div class="modal-content card-outline card-primary">
            <div class="modal-header">
                <h4 class="modal-title"> <b>Horarios de Atencion Disponibles</b> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-horario-disponible" method="POST">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Fecha</label>
                                <input id="fecha-doctor" type="text" name="fecha" class="form-control" readOnly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Horas</label>
                                <select id="horario-doctor-disponible" class="form-control">
                                    <!-- <option value="0">Seleccion un Horario</option> -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <button type="submit" class="btn btn-block bg-gradient-primary btn-md">Seleccionar
                            Horario</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>

<!-- MODAL SERVICIOS -->
<div class="modal fade" id="modal-servicios">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Servicios Disponibles</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="height: 200px !important; overflow: auto;">
                    <div class="col-12">
                        <div class="tabla-buscar-servicio">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="display: none">ID</th>
                                        <th>Nombres</th>
                                        <th>OK</th>
                                    </tr>
                                </thead>
                                <tbody id="servicio-body">

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

<!-- MODAL PACIENTES -->
<div class="modal fade" id="modal-pacientes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Pacientes Disponibles</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="buscar-paciente">Buscar Paciente</label>
                            <input type="text" class="form-control" placeholder="Ingrese la cédula o nombre" id="busqueda">
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 200px !important; overflow: auto;">
                    <div class="col-12">
                        <div class="tabla-buscar-mascota">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="display: none">ID</th>
                                        <th>Cedula</th>
                                        <th>Nombres</th>
                                        <th>OK</th>
                                    </tr>
                                </thead>
                                <tbody id="paciente-body">

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

<script src="<?=BASE?>views/plugins/sweetalert2/sweetalert2.min.js"></script>

<script src="<?=BASE?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=BASE?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=BASE?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?=BASE?>views/plugins/pdfmake/pdfmake.min.js"></script>

<!-- fullCalendar 2.2.5 -->
<script src="<?=BASE?>views/plugins/moment/moment.min.js"></script>
<script src="<?=BASE?>views/plugins/fullcalendar/main.js"></script>
<script src="<?=BASE?>views/plugins/fullcalendar/locales/es.js"></script>

<script src="<?=BASE?>views/dist/js/scripts/nuevaCita.js?ver=1.1.1.1"></script>