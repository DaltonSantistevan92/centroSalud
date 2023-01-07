<?php

require_once 'app/error.php';

class CategoriasAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/categorias/listarXid' && $params) {
                    Route::get('/categorias/listarXid/:id', 'categoriasController@listarXid', $params);
                }else
                if ($ruta == '/categorias/listarXidInventario' && $params) {
                    Route::get('/categorias/listarXidInventario/:id', 'categoriasController@listarXidInventario', $params);
                }else
                if ($ruta == '/categorias/listar') {
                    Route::get('/categorias/listar', 'categoriasController@listarCategorias');
                }else
                if ($ruta == '/categorias/grafico') {
                    Route::get('/categorias/grafico', 'categoriasController@graficoCategorias');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/categorias/guardar') {
                    Route::post('/categorias/guardar', 'categoriasController@guardarCategoria');
                }else
                if ($ruta == '/categorias/eliminar') {
                    Route::post('/categorias/eliminar', 'categoriasController@eliminarCategoria');
                }else
                if ($ruta == '/categorias/editar') {
                    Route::post('/categorias/editar', 'categoriasController@editarCategoria');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                } 
            break;
        }
    }
}
