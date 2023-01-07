<?php

class InicioController
{

    public function administrador()
    {
        include_once 'views/contents/default.php';
    }

    public function recepcionista()
    {
        include_once 'views/contents/inicioRecepcionista.php';
    }

    public function doctor()
    {
        include_once 'views/contents/inicioDoctor.php';
    }

}