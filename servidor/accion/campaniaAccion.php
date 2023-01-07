<?php

require_once 'app/error.php';

class CampaniaAccion 
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/campania/buscarCampania' && $params) {
                    Route::get('/campania/buscarCampania/:texto', 'campaniaController@buscarCampania', $params);
                }else
                if ($ruta == '/campania/listar') {
                    Route::get('/campania/listar', 'campaniaController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/campania/guardar') {
                    Route::post('/campania/guardar', 'campaniaController@guardar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;
        }
    }
}
