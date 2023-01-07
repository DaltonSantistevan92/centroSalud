<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Campañas</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Crear
                                    Campañas</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Asignar
                                    Enfermeros</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <form id="form-datos-campania" method="POST">
                                    <medium class="text-primary"> <b>DATOS DE LA CAMPAÑA</b> </medium>
                                    <hr class="bg-primary" style="margin: 0;">
                                    <div class="row mt-2">
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Centro de Salud</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-hospital"></i></span>
                                                </div>
                                                <input id="new-nombre" type="text" name="nombre" class="form-control"
                                                    value="Centro de Salud Jose Garces" readOnly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Nombre Campaña</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-tents"></i></span>
                                                </div>
                                                <input id="campania-nombre" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <medium class="text-primary"> <b>UBICACION DE LA COMPAÑA</b> </medium>
                                    <hr class="bg-primary" style="margin: 0;">
                                    <div class="row mt-2">
                                        <div class="col-12 col-md-3 form-group">
                                            <label for="">Provincias</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-p"></i></span>
                                                </div>
                                                <select name="pronvincia" id="campania-provincia" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 form-group">
                                            <label for="">Cantones</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-c"></i></span>
                                                </div>
                                                <select name="cantones" id="campania-canton" class="form-control">
                                                    <option value="">Seleccione un Canton</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 form-group">
                                            <label for="">Parroquias</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-light fa-p"></i></span>
                                                </div>
                                                <select name="parroquia" id="campania-parroquia" class="form-control">
                                                    <option value="">Seleccione una Parroquia</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 form-group">
                                            <label for="">Barrios</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-location-arrow"></i></span>
                                                </div>
                                                <select name="barrio" id="campania-barrio" class="form-control">
                                                    <option value="">Seleccione un Barrio</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <medium class="text-primary"> <b>INTERVALO DE EDAD - FECHA CAMPAÑA</b> </medium>
                                    <hr class="bg-primary" style="margin: 0;">
                                    <div class="row mt-2">
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Intervalo de Edad</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-list-ul"></i></span>
                                                </div>
                                                <select name="sexo" id="campania-edad" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Fecha Campaña</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fa-solid fa-calendar-check"></i></span>
                                                </div>
                                                <input id="campania-fecha" type="date" name="fecha" class="form-control"
                                                    min=<?php $hoy=date("Y-m-d"); echo $hoy;?>>
                                            </div>
                                        </div>
                                    </div>

                                    <medium class="text-primary"> <b>ASIGNACION DE PRODUCTOS</b> </medium>
                                    <hr class="bg-primary" style="margin: 0;">
                                    <div class="row mt-2" id="ocultar">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-outline-dark btn-sm" id="abril-modal-prod"><i
                                                    class="fas fa-search mr-2"></i> Agregar
                                                Producto</button>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12 col-md-5">
                                            <input type="hidden" id="producto-id">
                                            <div class="form-group">
                                                <label for="">Producto</label>
                                                <input id="producto-nombre" type="text" readOnly
                                                    class="form-control form-control-sm" placeholder="Producto">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <div class="form-group">
                                                <label for="">Stock</label>
                                                <input id="producto-stock" type="text" readOnly
                                                    class="form-control form-control-sm" placeholder="Stock">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Cantidad</label>
                                                <input id="producto-cantidad" type="text"
                                                    class="form-control form-control-sm solo-numeros"
                                                    placeholder="Cantidad">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <button id="agregar-producto" class="btn btn-dark btn-sm"
                                                style="margin-top: 30px;"><i class="fas fa-plus"></i></button>
                                            <button id="btn-borrar" class="btn btn-primary btn-sm"
                                                style="margin-top: 30px;"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>

                                    <div class="row mt-2 d-none" id="table-detalle-campania">
                                        <div class="table-responsive">
                                            <div class="box-header">
                                                <h5 class="box-title"><b>Detalle de la Asignación</b></h5>
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
                                                    <tbody id="listProdCampania">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-outline-primary" type="submit"><i
                                                    class="fas fa-save mr-2"></i>Guardar Registro</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="card card-outline card-primary shadow-lg">
                                            <div class="card-header">
                                                <h3 class="card-title"> <b>Campañas</b> </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Buscar Campaña</label>
                                                            <input id="buscar-campania" type="text" class="form-control"
                                                                placeholder="Ingrese nombre de la campaña a buscar" pattern="[A-Za-z ]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="campania-id">
                                                <div class="row" style="height: 230px !important; overflow: auto;">
                                                    <div class="col-12">
                                                        <div class="tabla-buscar-campania">
                                                            <table
                                                                class="table table-bordered table-striped text-center table-sm">
                                                                <thead>
                                                                    <tr class="bg-light">
                                                                        <th>#</th>
                                                                        <th style="display: none">ID</th>
                                                                        <th>Nombre Campaña</th>
                                                                        <th>Seleccionar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="campania-body">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card card-outline card-primary shadow-lg">
                                            <div class="card-header">
                                                <h3 class="card-title"> <b>Enfermeros</b> </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Buscar Enfermero</label>
                                                            <input id="buscar-enfermero" type="text"
                                                                class="form-control"
                                                                placeholder="Ingrese nombre o apellido del enfermero a buscar">
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="enfermero-id">
                                                <div class="row" style="height: 230px !important; overflow: auto;">
                                                    <div class="col-12">
                                                        <div class="tabla-buscar-enfermero">
                                                            <table
                                                                class="table table-bordered table-striped text-center table-sm">
                                                                <thead>
                                                                    <tr class="bg-light">
                                                                        <th>#</th>
                                                                        <th style="display: none">ID</th>
                                                                        <th>Nombres</th>
                                                                        <th>Seleccionar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="enfermero-body">
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
                                                <h3 class="card-title"> <b>Asignar Campaña - Enfermero</b>
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="info-box mb-3 bg-dark">
                                                            <span class="info-box-icon"><i
                                                                    class="fa-solid fa-tents"></i></span>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Campaña</span>
                                                                <span class="info-box-number"
                                                                    id="campania-seleccionado">----------</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-box mb-3 bg-dark">
                                                            <span class="info-box-icon"><i
                                                                    class="fa-solid fa-user-doctor"></i></span>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Enfermero</span>
                                                                <span class="info-box-number"
                                                                    id="enfermero-seleccionado">----------</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row d-flex justify-content-center">
                                                    <button class="btn btn-outline-primary btn-sm"
                                                        id="asignar-campania-enfermero"><i
                                                            class="fas fa-check mr-2"></i>Asignar</button>

                                                </div>
                                                <div class="row" style="height: 200px !important; overflow: auto;">
                                                    <div class="col-12 mt-3">
                                                        <h3> <b>Lista de Asignaciones</b></h3>
                                                        <div class="tabla-buscar-asignacion">
                                                            <table
                                                                class="table table-bordered table-striped text-center table-sm">
                                                                <thead>
                                                                    <tr class="bg-light">
                                                                        <th>#</th>
                                                                        <th style="display: none">ID</th>
                                                                        <th>Campaña</th>
                                                                        <th>Canton</th>
                                                                        <th>Parroquia</th>
                                                                        <th>Barrio</th>
                                                                        <th>Enfermero</th>
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

<!-- MODAL PRODUCTOS -->
<div class="modal fade" id="modal-productos" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Productos Disponibles</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="buscar-producto">Buscar Producto</label>
                            <input type="text" class="form-control" placeholder="Ingrese el nombre o código del producto" id="busqueda">
                        </div>
                    </div>
                </div> -->

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

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/nuevaCampania.js?ver=1.1.1.5"></script>