<?php

require_once 'app/error.php';

class EnfermeroAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/enfermero/listarEnfermeroCampania' && $params) {
                    Route::get('/enfermero/listarEnfermeroCampania/:id', 'enfermeroController@listarEnfermeroCampania',$params);
                }else
                if ($ruta == '/enfermero/buscarEnfermero' && $params) {
                    Route::get('/enfermero/buscarEnfermero/:texto', 'enfermeroController@buscarEnfermero', $params);
                }else
                if ($ruta == '/enfermero/listar') {
                    Route::get('/enfermero/listar', 'enfermeroController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                 
            break;
        }
    }
}
