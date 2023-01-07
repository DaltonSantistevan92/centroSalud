<?php

require_once 'app/error.php';

class PacientesAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/pacientes/listarPacientesxId' && $params) {
                    Route::get('/pacientes/listarPacientesxId/:id', 'pacientesController@listarPacientesxId',$params);
                }else
                if ($ruta == '/pacientes/listarPacientes') {
                    Route::get('/pacientes/listarPacientes', 'pacientesController@listarPacientes');
                }else
                if ($ruta == '/pacientes/listarPacientesDataTable') {
                    Route::get('/pacientes/listarPacientesDataTable', 'pacientesController@listarPacientesDataTable');
                }else
                if ($ruta == '/pacientes/contar') {
                    Route::get('/pacientes/contar', 'pacientesController@contar');
                }else 
                if ($ruta == '/pacientes/search' && $params) {
                    Route::get('/pacientes/search/:texto', 'pacientesController@buscarPacientes',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/pacientes/guardar') {
                    Route::post('/pacientes/guardar', 'pacientesController@guardarPacientes');
                }else
                if ($ruta == '/pacientes/eliminar') {
                    Route::post('/pacientes/eliminar', 'pacientesController@eliminarPacientes');
                }else
                if ($ruta == '/pacientes/editar') {
                    Route::post('/pacientes/editar', 'pacientesController@editarPacientes');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;
        }
    }
}
