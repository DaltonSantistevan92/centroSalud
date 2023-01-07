<?php

require_once 'app/error.php';

class ProvinciaAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/provincia/listarxId' && $params) {
                    Route::get('/provincia/listarxId/:id', 'provinciaController@listarXidProvincia',$params);
                }else
                if ($ruta == '/provincia/listar') {
                    Route::get('/provincia/listar', 'provinciaController@listarProvincia');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                
            break;
        }
    }
}
