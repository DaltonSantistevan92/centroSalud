<?php

require_once 'app/error.php';

class CitasAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) { 
            case 'get':
                if ($ruta == '/citas/listar' && $params) {
                    Route::get('/citas/listar/:id', 'citasController@listarCitasXId', $params);
                }else
                if ($ruta == '/citas/updateEntrada' && $params) {
                    Route::get('/citas/updateEntrada/:id', 'citasController@updateEntrada', $params);
                }else
                if ($ruta == '/citas/listarCitasDataTable') {
                    Route::get('/citas/listarCitasDataTable', 'citasController@listarCitasDataTable');
                }else 
                if ($ruta == '/citas/cancelar' && $params) {
                    Route::get('/citas/cancelar/:id/:estado_cita_id', 'citasController@cancelarCitaXId',$params);
                }else
                if ($ruta == '/citas/pendientesDataTable' && $params) {
                    Route::get('/citas/pendientesDataTable/:personas_id/:estado_cita_id', 'citasController@listarCitasPendientesDataTable',$params);
                }else 
                if ($ruta == '/citas/cancelarxDoctor' && $params) {
                    Route::get('/citas/cancelarxDoctor/:id/:estado_cita_id', 'citasController@cancelarxDoctor',$params);
                }else
                if ($ruta == '/citas/listarCitasCanceladasxDoctor' && $params) {
                    Route::get('/citas/listarCitasCanceladasxDoctor/:personas_id/:estado_cita_id', 'citasController@listarCitasCanceladasxDoctor',$params);
                }else
                if ($ruta == '/citas/listarCitasAtendidasxDoctor' && $params) {
                    Route::get('/citas/listarCitasAtendidasxDoctor/:personas_id/:estado_cita_id', 'citasController@listarCitasAtendidasxDoctor',$params);
                }else
                if ($ruta == '/citas/verCitasAtendidas' && $params) {
                    Route::get('/citas/verCitasAtendidas/:id', 'citasController@verCitasAtendidas', $params);
                }else
                if ($ruta == '/citas/verCitasEntregadas' && $params) {
                    Route::get('/citas/verCitasEntregadas/:id', 'citasController@verCitasEntregadas', $params);
                }else 
                if ($ruta == '/citas/entregaProductoxReceta' && $params) {
                    Route::get('/citas/entregaProductoxReceta/:cita_id/:estado_cita_id/:satisfacion_id', 'citasController@entregaProductoxRecetaMovimientoInventario',$params);
                }else
                if ($ruta == '/citas/listarCitasAtendidaPeroNoEntregada') { 
                    Route::get('/citas/listarCitasAtendidaPeroNoEntregada', 'citasController@listarCitasAtendidaPeroNoEntregada');
                }else
                if ($ruta == '/citas/listarCitasAtendidaEntregadayNoEntregada') { // 
                    Route::get('/citas/listarCitasAtendidaEntregadayNoEntregada', 'citasController@listarCitasAtendidaEntregadayNoEntregada');
                }else
                if ($ruta == '/citas/listarCitasEntregada') {
                    Route::get('/citas/listarCitasEntregada', 'citasController@listarCitasEntregada');
                }else
                if ($ruta == '/citas/regresionLineal' && $params) {
                    Route::get('/citas/regresionLineal/:inicio/:fin/:temporalidad', 'citasController@regresionLineal',$params);
                }else
                if ($ruta == '/citas/pendienteContar') {
                    Route::get('/citas/pendienteContar', 'citasController@pendienteContar');
                }else
                if ($ruta == '/citas/atendidaContar') {
                    Route::get('/citas/atendidaContar', 'citasController@atendidaContar');
                }else
                if ($ruta == '/citas/indicadoresGlobales') {
                    Route::get('/citas/indicadoresGlobales', 'citasController@indicadoresGlobales');//endpoint o ruta de kpi generales
                }else
                if ($ruta == '/citas/indicadoresGlobalesDate'  && $params) {
                    Route::get('/citas/indicadoresGlobalesDate/:inicio/:fin', 'citasController@indicadoresGlobalesDate', $params);//endpoint o ruta de kpi paremetrizada x fechas
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post': 
                if ($ruta == '/citas/guardarCita') {
                    Route::post('/citas/guardarCita', 'citasController@guardarCita');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }  
            break;
        }
    }
}
