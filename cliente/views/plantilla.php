<?php

    require_once 'config/base.php';
    require_once 'config/controller.php';

    require_once 'views/layouts/header.php';

    if(count($_GET) == 0){
        require_once 'views/pages/login.php';
    }else
    if(isset($_GET['url']) && $_GET['url'] == 'login'){
        require_once 'views/pages/login.php';
    }
    else{
        $controller = new Controller();

        if(!$controller->procesar()){
            //pagina de error 404
            require_once 'views/pages/404.php';
        }else{
            require_once 'views/layouts/navbar.php';
            require_once 'views/layouts/sidebar.php';
            
            $controller->include();
            require_once 'views/layouts/notificaciones.php';
        }  
    }

    require_once 'views/layouts/footer.php';

