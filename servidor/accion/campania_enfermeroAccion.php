<?php

require_once 'app/error.php';

class Campania_EnfermeroAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) { 
            case 'get': 
                if ($ruta == '/campania_enfermero/listarDetalles' && $params) {//ruta para la aplicacion de vacuna
                    Route::get('/campania_enfermero/listarDetalles/:campania_id/:enfermero_id', 'campania_enfermeroController@listarDetalles',$params);
                }else
                if ($ruta == '/campania_enfermero/listar') {
                    Route::get('/campania_enfermero/listar', 'campania_enfermeroController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/campania_enfermero/guardar') {
                    Route::post('/campania_enfermero/guardar', 'campania_enfermeroController@guardar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }  
            break;

            case 'delete':
                if ($params) {
                    if ($ruta == '/campania_enfermero/eliminar') {
                        Route::delete('/campania_enfermero/eliminar/:id', 'campania_enfermeroController@eliminar', $params);
                    } 
                } else {
                    ErrorClass::e(400, 'No ha enviado parámetros por la url');
                }
            break;
        }
    }
}
