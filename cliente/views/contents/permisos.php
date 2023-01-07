<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center form-group flex-column mt-4">
                <label for="">Cargo</label>
                <select class="form-control" id="select-cargo">
                    <!--  <option>option 1</option> -->
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline shadow">
                    <div class="card-header">
                        <h3 class="card-title">Permisos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-sm text-nowrap">
                            <thead>
                                <tr>
                                    <th>Menus</th>
                                    <th>Permisos</th>
                                </tr>
                            </thead>
                            <tbody id="body-menus">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="<?=BASE?>views/dist/js/scripts/permisos.js"></script>