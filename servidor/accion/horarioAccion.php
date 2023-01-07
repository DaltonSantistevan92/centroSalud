<?php

require_once 'app/error.php';

class HorarioAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/horario/listarEventoDoctorHorario' && $params) {//listar eventos con su doctor y horario establecido
                    Route::get('/horario/listarEventoDoctorHorario/:doctor_id', 'horarioController@listarEventoDoctorHorario', $params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/horario/guardarHorario') {  
                    Route::post('/horario/guardarHorario', 'horarioController@guardarHorario'); 
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'delete':
                if ($params) {
                    if ($ruta == '/horario/eliminarDoctorHorario') {
                        Route::delete('/horario/eliminarDoctorHorario/:horario_id/:doctor_id', 'horarioController@eliminarDoctorHorario', $params);
                    } 
                } else {
                    ErrorClass::e(400, 'No ha enviado parámetros por la url');
                }
            break;
        }
    }
}
