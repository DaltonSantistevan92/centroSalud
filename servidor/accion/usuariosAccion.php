<?php
require_once 'app/error.php';

class UsuariosAccion{
    
    public function index($metodo_http, $ruta, $params = null){
        switch($metodo_http){
            case 'get':
                if($ruta == '/usuarios/listar' && $params){
                    Route::get('/usuarios/listar/:id', 'usuariosController@listarId',$params);
                }else
                if($ruta == '/usuarios/card'){
                    Route::get('/usuarios/card', 'usuariosController@cardUsuario');
                }else
                if($ruta == '/usuarios/cardDoctor'){
                    Route::get('/usuarios/cardDoctor', 'usuariosController@cardDoctor');
                }else
                if($ruta == '/usuarios/cardEnfermero'){
                    Route::get('/usuarios/cardEnfermero', 'usuariosController@cardEnfermero');
                }else
                if($ruta == '/usuarios/contar'){
                    Route::get('/usuarios/contar', 'usuariosController@contar');
                }else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
            break;
            
            case 'post':
                if($ruta == '/usuarios/login'){
                    Route::post('/usuarios/login', 'usuariosController@login');
                }else 
                if($ruta == '/usuarios/guardarUsuario'){
                    Route::post('/usuarios/guardarUsuario', 'usuariosController@guardarUsuario');
                }else
                if ($ruta == '/usuarios/subirFoto') {
                    Route::post('/usuarios/subirFoto', 'usuariosController@subirFoto', true);
                }else
                if ($ruta == '/usuarios/eliminar') {
                    Route::post('/usuarios/eliminar', 'usuariosController@eliminarUsuario');
                }else
                if ($ruta == '/usuarios/editarUsuario') {
                    Route::post('/usuarios/editarUsuario', 'usuariosController@editarUsuario');
                }else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
            break;

        }

    }
}



