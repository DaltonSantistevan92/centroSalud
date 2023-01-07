<?php

require_once 'app/error.php';

class Aplicar_VacunaAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/aplicar_vacuna/contarVacunasAplicadas' && $params) {
                    Route::get('/aplicar_vacuna/contarVacunasAplicadas/:campania_id', 'aplicar_vacunaController@contarVacunasAplicadas',$params);
                }else
                if ($ruta == '/aplicar_vacuna/listar' && $params) {
                    Route::get('/aplicar_vacuna/listar/:id', 'aplicar_vacunaController@listar', $params);
                }else
                if ($ruta == '/aplicar_vacuna/listarDataTableVacunacion') {
                    Route::get('/aplicar_vacuna/listarDataTableVacunacion', 'aplicar_vacunaController@listarDataTableVacunacion');
                }else
                if ($ruta == '/aplicar_vacuna/desocuparEnfermero' && $params ) { 
                    Route::get('/aplicar_vacuna/desocuparEnfermero/:enfermero_id', 'aplicar_vacunaController@desocuparEnfermero',$params);
                }else
                if ($ruta == '/aplicar_vacuna/pacienteVacunadoxCampania' && $params) {  
                    Route::get('/aplicar_vacuna/pacienteVacunadoxCampania/:campania_id/:inicio/:fin/:limite', 'aplicar_vacunaController@pacienteVacunadoxCampania', $params); 
                }else
                if ($ruta == '/aplicar_vacuna/progreso' && $params) {  
                    Route::get('/aplicar_vacuna/progreso/:campania_id/:inicio/:fin', 'aplicar_vacunaController@progreso', $params); 
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/aplicar_vacuna/guardar') {
                    Route::post('/aplicar_vacuna/guardar', 'aplicar_vacunaController@guardar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }  
            break;
        }
    }
}
