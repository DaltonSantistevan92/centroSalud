<?php

require_once 'app/error.php';

class EspecialidadAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/especialidad/listar') {
                    Route::get('/especialidad/listar', 'especialidadController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                
            break;
        }
    }
}
