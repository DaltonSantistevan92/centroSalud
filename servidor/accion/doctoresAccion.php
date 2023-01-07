<?php

require_once 'app/error.php';

class DoctoresAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/doctores/listarDoctorEspecialidad' && $params) {
                    Route::get('/doctores/listarDoctorEspecialidad/:id', 'doctoresController@listarDoctorEspecialidad',$params);
                }else
                if ($ruta == '/doctores/listarDoctor') {
                    Route::get('/doctores/listarDoctor', 'doctoresController@listarDoctor');
                }else
                if ($ruta == '/doctores/contar') {
                    Route::get('/doctores/contar', 'doctoresController@contar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            /* case 'post':
                if ($ruta == '/doctores/guardar') { 
                    Route::post('/doctores/guardar', 'doctoresController@guardar'); 
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break; */

        }
    }
}
