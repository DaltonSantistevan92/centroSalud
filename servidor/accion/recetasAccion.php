<?php

require_once 'app/error.php';

class RecetasAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':  
                if ($ruta == '/recetas/productoMasEntregado' && $params) {  
                    Route::get('/recetas/productoMasEntregado/:inicio/:fin/:limite', 'recetasController@productoMasEntregado', $params); 
                }else
                if ($ruta == '/recetas/listar') {
                    Route::get('/recetas/listar', 'recetasController@listar');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/recetas/guardar') {
                    Route::post('/recetas/guardar', 'recetasController@guardarReceta'); 
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                
            break;
        }
    }
}
