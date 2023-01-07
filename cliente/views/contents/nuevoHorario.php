<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Gestionar Horarios</b> </h3>
                       
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-7">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL NUEVO HORARIO -->
<div class="modal fade" id="modal-horario">
    <div class="modal-dialog">
        <div class="modal-content card-outline card-primary">
            <div class="modal-header">
                <h4 class="modal-title"> <b>Nuevo Horario de Atencion</b> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-horario-doctor" method="POST"> 
                    <div class="row">
                        <div class="col-6 form-group">
                            <input type="hidden" id="doctor-id">
                            <label>Hora de Entrada</label>
                            <input type="time" class="form-control" id="hora-entrada"
                                placeholder="Ingrese la Hora de Entrada">
                        </div>
                        <div class="col-6 form-group">
                            <label>Hora de Salida</label>
                            <input type="time" class="form-control" id="hora-salida"
                                placeholder="Ingrese la Hora de Salida">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Fecha</label>
                                <input id="fecha-doctor" type="text" name="fecha" class="form-control" readOnly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">Intervalo</label>
                                <select id="intervalo-doctor" class="form-control">
                                    <option value="0">Seleccion un Intervalo</option>
                                    <option value="30">30 min</option>
                                    <option value="60">60 min</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <button type="submit" class="btn btn-block bg-gradient-primary btn-md">Crear Horario</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>

<!-- MODAL HORARIOS -->
<div class="modal fade" id="modal-lista-horario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-outline card-primary">
            <div class="modal-header">
                <h4 class="modal-title"> <b>Horarios de Atencion Disponibles</b> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body table-responsive p-3" style="height: 255px;overflow: auto;">
                    <table class="table table-hover table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Horario</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="body-lista-horario">

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer justify-content-between"> </div>
        </div>
    </div>
</div>

<script src="<?=BASE?>views/plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- fullCalendar 2.2.5 -->
<script src="<?=BASE?>views/plugins/moment/moment.min.js"></script>
<script src="<?=BASE?>views/plugins/fullcalendar/main.js"></script>
<script src="<?=BASE?>views/plugins/fullcalendar/locales/es.js"></script>

<script src="<?=BASE?>views/dist/js/scripts/nuevoHorario.js?ver=1.1.1.1"></script>