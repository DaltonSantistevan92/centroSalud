<?php

require_once 'app/error.php';

class Doctores_EspecialidadAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/doctores_especialidad/listar') {
                    Route::get('/doctores_especialidad/listar', 'doctores_especialidadController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/doctores_especialidad/guardar') {
                    Route::post('/doctores_especialidad/guardar', 'doctores_especialidadController@guardar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;


            case 'delete':
                if ($params) {
                    if ($ruta == '/doctores_especialidad/eliminarDoctorEspecialidad') {
                        Route::delete('/doctores_especialidad/eliminarDoctorEspecialidad/:id', 'doctores_especialidadController@eliminarDoctorEspecialidad', $params);
                    } 
                } else {
                    ErrorClass::e(400, 'No ha enviado parámetros por la url');
                }
            break;
        }
    }
}
