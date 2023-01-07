<body class="hold-transition login-page login-per">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <i class="fa-solid fa-hospital mr-2" style="font-size: 20px;"></i><a href="../../index2.html" class="h5"><b>CENTRO DE SALUD JOSE GARCES</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg text-primary h4"> <b>Iniciar Sesión</b> </p>

                <form id="form-login" method="post">
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <input type="text" class="form-control" placeholder="Usuario" id="dato-user">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <input type="password" class="form-control" placeholder="contraseña" id="dato-clave">
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-outline-primary btn-block" id="btn-ingresar">Ingresar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <script src="<?=BASE?>views/dist/js/scripts/login.js?ver=1.1.1.1"> </script>