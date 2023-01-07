<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                <h1 class="m-0"> <b>Dashboard KPI</b> </h1>
            </div>

            <div class="col-sm-9">
                <div class="row d-flex justify-content-center">
                    <div class="col-6 col-md-4 col-lg-3 form-group">
                        <label>Fecha Inicio</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                            </div>
                            <input id="fecha-inicio-r-m" type="date" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 form-group">
                        <label>Fecha fin</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-solid fa-calendar-check"></i></span>
                            </div>
                            <input id="fecha-fin-r-m" type="date" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 form-group">
                        <button class="btn btn-outline-dark btn-sm " id="btn-consulta" style="margin-top: 35px;">
                            <i class=" fa fa-search mr-2"></i> Consultar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-5">
                <div class="card card-light shadow-lg" style="margin-top: -20px;">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h5 class="text-bold">Satisfacción del Paciente</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h5 class="text-center"><b>CSAT Positivo</b></h5>
                                <div id="chartDivPos" style="max-width: 250px; height: 200px;margin: 0px auto;"></div>
                                <div class="text-right d-flex justify-content-between">
                                    <small># Valoraciones <span class="badge badge-warning" id="valPositivo">0</span></small>
                                    <small>CSAT Promedio <span class="badge badge-success" id="csatPositivo">0</span></small>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <h5 class="text-center"><b>CSAT Negativo</b></h5>
                                <div id="chartDivNeg" style="max-width: 250px; height: 200px;margin: 0px auto;"></div>
                                <div class="text-right d-flex justify-content-between">
                                    <small># Valoraciones <span class="badge badge-warning" id="valNegativo">0</span></small>
                                    <small>CSAT Promedio <span class="badge badge-success" id="csatNegativo">0</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-7">
                <div class="card card-light shadow-lg" style="margin-top: -20px;">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="text-center mb-3">
                            <h5 class="text-bold">Atención de Citas</h5>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div id="chartDivCitas" style="max-width: 700px; height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col col-md-4">
                <div class="card card-light shadow-lg">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h5 class="text-bold">Tiempo de espera del paciente</h5>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12">
                                <div class="row justify-content-center"><h6 class="text-bold">Citas de 30 min</h6></div>
                                <div class="row justify-content-center">
                                    <div class="col">
                                        <div id="chartDiv1" class="chartDiv" style="max-width:250px;height: 110px;"></div>
                                    </div>
                                    <div class="col">
                                        <div id="chartDiv2" class="chartDiv" style="max-width:250px;height: 110px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-12">
                            <div class="row justify-content-center"><h6 class="text-bold">Citas de 60 min</h6></div>
                                <div class="row justify-content-center">
                                    <div class="col">
                                        <div id="chartDiv3" class="chartDiv" style="max-width:250px;height: 110px;"></div>
                                    </div>
                                    <div class="col">
                                        <div id="chartDiv4" class="chartDiv" style="max-width:250px;height: 110px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="col col-md-8">
                <div class="card card-light shadow-lg">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h5 class="text-bold">Cantidad de vacunas por campañas</h5>
                        </div>
                        <div class="row d-flex justify-content-center flex-row" id="box-canva1">

                        </div>
                        <!-- <div >
                            <canvas id="revenue-chart-canvas" width="700" height="300"> </canvas>
                        </div> -->
                        <div>
                            <h3 id="msjNoInfo" class="text-warning text-center text-bold"></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jscharting.com/latest/jscharting.js"></script>
    <script type="text/javascript" src="https://code.jscharting.com/latest/modules/types.js"></script>
    <script type="text/javascript" src="https://code.jscharting.com/latest/modules/toolbar.js"></script>
    <script src="<?= BASE ?>views/plugins/chart.js/Chart.min.js"></script>
    <script src="<?= BASE ?>views/plugins/Toast/js/Toast.min.js"></script>
    <script src="<?= BASE ?>views/dist/js/scripts/dashboardKpi.js?ver=1.1.1.20"></script>