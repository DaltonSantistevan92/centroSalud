<style>
    .box-img-producto {
        width: 90px;
        height: 90px;
        overflow: hidden;
        margin-left: auto;
        margin-right: auto;
    }

    .box-img-producto>img {
        width: 100% !important;
        height: 100% !important;
    }

    .pt-25 {
        padding-top: 30px !important;
    }
</style>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3"> <b>Administración de Productos</b> </h3>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Crear
                                    Productos</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Listar
                                    Productos</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">
                                    <div class="col-4 col-md-6 col-lg-6 d-flex">
                                        <input type="text" class="form-control solo-letras" placeholder="Nueva Categoría" minlength="4" required id="texto-categoria">
                                        <button class="btn btn-outline-primary ml-2" id="nueva-categoria">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="col-4 col-md-6 col-lg-3 d-flex">
                                        <a class="btn btn-dark form-control" href="<?= BASE ?>administracion/categoria" data-backdrop="static" data-keyboard="false">
                                            <i class="fas fa-list-ul"></i>
                                            Listar Categorías
                                        </a>
                                    </div>
                                </div>
                                <hr class="bg-dark">
                                <form id="form-datos-productos" method="POST">
                                    <div class="row mt-2">
                                        <div class="col-12 col-md-2 form-group">
                                            <label for="">Código</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-barcode"></i></span>
                                                </div>
                                                <input id="codigo-producto" type="text" class="form-control text-center" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 form-group">
                                            <label for="">Nombre</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-clipboard-check"></i></span>
                                                </div>
                                                <input id="nombre-producto" type="text" name="nombre" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Categoría</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-tags"></i></span>
                                                </div>
                                                <select name="categoria" id="select-categoria" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-5 form-group">
                                            <label for="">Imagen</label>
                                            <div class="form-group">

                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="imagen-producto" accept="image/*">
                                                    <label class="custom-file-label" for="imagen-producto">Subir
                                                        Imagen</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-1 form-group">
                                            <label for="">Stock</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                                                </div>
                                                <input id="nombre-producto" type="text" name="cedula" class="form-control text-center" placeholder="0" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 form-group">
                                            <label for="">Descripción</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa-solid fa-rectangle-list"></i></span>
                                                </div>
                                                <textarea class="form-control form-control-sm" rows="1" id="descripcion-producto" style="height: 38px;"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="d_campania">
                                                <label for="d_campania" class="custom-control-label">Disponible para campaña</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button class="btn btn-outline-primary" type="submit"><i class="fas fa-save mr-2"></i>Guardar Registro</button>
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
                                                        <table id="tabla-productos" class="table table-bordered table-striped text-center">
                                                            <thead>
                                                                <tr class="bg-light">
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Imagen</th>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Categoria</th>
                                                                    <th>Stock</th>
                                                                    <th>Fecha</th>
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

<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>

<!-- MODAL EDITAR -->
<div class="modal fade" id="modal-editar-producto">
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
                    <input type="hidden" id="producto-id">
                    <form id="actualizar-productos" method="POST">
                        <div class="row mt-2">
                            <div class="col-12 col-md-2 form-group">
                                <label for="">Código</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-barcode"></i></span>
                                    </div>
                                    <input id="upd-codigo-producto" type="text" class="form-control text-center" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="">Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-clipboard-check"></i></span>
                                    </div>
                                    <input id="upd-nombre-producto" type="text" name="nombre" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label for="">Categoría</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-tags"></i></span>
                                    </div>
                                    <select name="categoria" id="upd-select-categoria" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3 form-group">
                                <label for="">Stock</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                                    </div>
                                    <input id="upd-stock-producto" type="text" class="form-control text-center" placeholder="0" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-9 form-group">
                                <label for="">Descripción</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-rectangle-list"></i></span>
                                    </div>
                                    <textarea class="form-control form-control-sm" rows="1" id="upd-descripcion-producto" style="height: 38px;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="d_campania_e">
                                    <label for="d_campania_e" class="custom-control-label">Disponible para campaña</label>
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

<script src="<?= BASE ?>views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= BASE ?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= BASE ?>views/plugins/jszip/jszip.min.js"></script>
<script src="<?= BASE ?>views/plugins/pdfmake/pdfmake.min.js"></script>

<script src="<?= BASE ?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?= BASE ?>views/dist/js/scripts/nuevoProducto.js?ver=1.1.1.1"></script>