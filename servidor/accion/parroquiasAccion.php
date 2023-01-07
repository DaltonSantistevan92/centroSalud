<?php

require_once 'app/error.php';

class ParroquiasAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/parroquias/listarxId' && $params) {
                    Route::get('/parroquias/listarxId/:id', 'parroquiasController@listarXidParroquias',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                
            break;
        }
    }
}
