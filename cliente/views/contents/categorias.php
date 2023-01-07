<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 mt-3">
                <a class="btn btn-dark form-control" href="<?= BASE ?>administracion/nuevoProducto"
                    data-backdrop="static" data-keyboard="false">
                    <i class="fas fa-box-archive mr-2"></i>
                    Nuevo Producto
                </a>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6 mt-3">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Listar Categorías</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row" style="height: 450px !important; overflow: auto;">
                            <div class="col-12">
                                <div class="tabla-buscar-servicio">
                                    <table class="table table-hover text-nowrap text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="display: none">ID</th>
                                                <th>Categoría</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="categorias-body">

                                        </tbody>
                                    </table>
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

<!-- MODAL CATEGORIA -->
<div class="modal fade" id="modal-editar-categoria">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Editar Categoría</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="contanier-fluid">
                    <form method="POST" id="update-categorias">
                        <div class="row">
                            <div class="col-12 form-group">
                                <input type="hidden" id="upd-categoria-id">
                                <label for="">Categoría</label>
                                <input type="text" class="form-control" placeholder="Nombre" id="upd-nombre-categoria">
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
            <div class="modal-footer justify-content-between">
            </div>
        </div>
    </div>
</div>

<script src="<?=BASE?>views/plugins/Toast/js/Toast.min.js"></script>
<script src="<?=BASE?>views/dist/js/scripts/categorias.js"></script>