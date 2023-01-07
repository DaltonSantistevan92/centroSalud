<?php

require_once 'app/error.php';

class Doctor_HorarioAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/doctor_horario/listarHoraxDia' && $params) {
                    Route::get('/doctor_horario/listarHoraxDia/:doctor_id/:dia', 'doctor_horarioController@listarHoraxDia',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                
            break;
        }
    }
}
