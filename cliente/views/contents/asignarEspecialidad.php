<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title"> <b>Doctores</b> </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="doctor-id">
                        <div class="row" style="height: 230px !important; overflow: auto;">
                            <div class="col-12">
                                <div class="tabla-buscar-doctor">
                                    <table class="table table-bordered table-striped text-center table-sm">
                                        <thead>
                                            <tr class="bg-light">
                                                <th>#</th>
                                                <th style="display: none">ID</th>
                                                <th>Cedula</th>
                                                <th>Nombres</th>
                                                <th>Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="doctor-body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-12 col-md-6 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title"> <b>Especialidades</b> </h3>
    
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="especialidad-id">
                        <div class="row" style="height: 230px !important; overflow: auto;">
                            <div class="col-12">
                                <div class="tabla-buscar-especialidad">
                                    <table class="table table-bordered table-striped text-center table-sm">
                                        <thead>
                                            <tr class="bg-light">
                                                <th>#</th>
                                                <th style="display: none">ID</th>
                                                <th>Especialidad</th>
                                                <th>Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="especialidad-body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>    
        </div>

        <div class="row justify-content-md-center">
            <div class="col-12 col-md-8 mt-1">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title"> <b>Asignar Especialidad</b> </h3>
    
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box mb-3 bg-dark">
                                    <span class="info-box-icon"><i class="fa-solid fa-user-doctor"></i></span>
    
                                    <div class="info-box-content">
                                        <span class="info-box-text">Doctor(a)</span>
                                        <span class="info-box-number" id="doc-seleccionado">----------</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box mb-3 bg-dark">
                                    <span class="info-box-icon"><i class="fa-solid fa-briefcase-medical"></i></span>
    
                                    <div class="info-box-content">
                                        <span class="info-box-text">Especialidad</span>
                                        <span class="info-box-number" id="esp-seleccionado">----------</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-outline-primary btn-sm" id="asignar-especialidad"><i
                                    class="fas fa-check mr-2"></i>Asignar</button>
    
                        </div>
                        <div class="row" style="height: 200px !important; overflow: auto;">
                            <div class="col-12 mt-3">
                                <h3> <b>Lista de Asignaciones</b></h3>
                                <div class="tabla-buscar-asignacion">
                                    <table class="table table-bordered table-striped text-center table-sm">
                                        <thead>
                                            <tr class="bg-light">
                                                <th>#</th>
                                                <th style="display: none">ID</th>
                                                <th>Doctor(a)</th>
                                                <th>Especialidad</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="asignacion-body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>


<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/asignarEspecialidad.js?ver=1.1.1.1"></script>