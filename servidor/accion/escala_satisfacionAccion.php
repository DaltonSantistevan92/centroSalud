<?php

require_once 'app/error.php';

class Escala_SatisfacionAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/escala_satisfacion/listar') {
                    Route::get('/escala_satisfacion/listar', 'escala_satisfacionController@listar');

                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            // case 'post':
            //     if ($ruta == '/escala_satisfaccion/guardar') {
            //         Route::post('/escala_satisfaccion/guardar', 'escala_satisfaccionController@guardar');
            //     }else {
            //         ErrorClass::e(404, "La ruta no existe");
            //     }  
            // break;
        }
    }
}
