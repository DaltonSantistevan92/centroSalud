<?php

require_once 'app/error.php';

class Intervalo_EdadAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/intervalo_edad/listar') {
                    Route::get('/intervalo_edad/listar', 'intervalo_edadController@listarIntervaloEdad',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                
            break;
        }
    }
}
