<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <b>Gráficos Estadísticos</b> </h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card card-primary shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title"><b>Cantidad de Citas Realizadas</b></h3>
                    </div>
                    <div class="card-body">
                        <canvas id="canvas1"
                            style="min-height: 250px; height: 250px; max-height: 300px; max-width: 100%; margin-top: 22px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card card-primary shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title"><b>Vista Rápida de la Información</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Usuarios</span>
                                        <span class="info-box-number" id="cantidad-usuarios">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-gray elevation-1"><i class="fas fa-user-tie"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pacientes</span>
                                        <span class="info-box-number" id="cantidad-pacientes">0</span>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-boxes"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Productos</span>
                                        <span class="info-box-number" id="cantidad-productos">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-md"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Doctores</span>
                                        <span class="info-box-number" id="cantidad-doctores">0</span>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-question-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Citas Pendientes</span>
                                        <span class="info-box-number" id="cantidad-pendientes">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Citas Atendidas</span>
                                        <span class="info-box-number" id="cantidad-atendidas">0</span>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card card-primary shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title"><b>Cantidad de Productos Por Categoría</b></h3>
                    </div>
                    <div class="card-body">
                        <canvas id="canvas2"
                            style="min-height: 250px; height: 250px; max-height: 300px; max-width: 100%; margin-top: 22px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card card-primary shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title"><b>Stock de Productos Por Categoría</b></h3>
                    </div>
                    <div class="card-body">
                        <canvas id="canvas3"
                            style="min-height: 250px; height: 250px; max-height: 300px; max-width: 100%; margin-top: 22px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=BASE?>views/plugins/html2pdf/html2pdf.bundle.js"></script>
<script src="<?=BASE?>views/plugins/chart.js/Chart.min.js"></script>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/dashboardEstadistico.js?ver=1.1.1.1"></script>