<?php

require_once 'app/error.php';

class AbastecerAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/abastecer/listar') {
                    Route::get('/abastecer/listar', 'abastecerController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/abastecer/guardar') {
                    Route::post('/abastecer/guardar', 'abastecerController@guardar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }  
            break;
        }
    }
}
