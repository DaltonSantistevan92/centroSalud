<?php

require_once 'app/error.php';

class CantonesAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/cantones/listarxId' && $params) {
                    Route::get('/cantones/listarxId/:id', 'cantonesController@listarXidCantones',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                
            break;
        }
    }
}
