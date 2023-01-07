<?php

require_once 'app/error.php';

class Estado_CitaAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/estado_cita/variosEstados') {
                    Route::get('/estado_cita/variosEstados', 'estado_citaController@variosEstados');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                
            break;
        }
    }
}
