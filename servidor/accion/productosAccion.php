<?php

require_once 'app/error.php';

class ProductosAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/productos/listarxId' && $params) {
                    Route::get('/productos/listarxId/:id', 'productosController@listarxIdProductos', $params);
                }else
                if ($ruta == '/productos/mostrarCodigo' && $params) {
                    Route::get('/productos/mostrarCodigo/:tipo', 'productosController@mostrarCodigo',$params);
                }else
                if ($ruta == '/productos/listar') {
                    Route::get('/productos/listar', 'productosController@listarProductos');
                }else
                if ($ruta == '/productos/listarParaReceta') {
                    Route::get('/productos/listarParaReceta', 'productosController@listarParaReceta');
                }else
                if ($ruta == '/productos/listarParaCampania') {
                    Route::get('/productos/listarParaCampania', 'productosController@listarParaCampania');
                }else
                if ($ruta == '/productos/listarProductosDataTable') {
                    Route::get('/productos/listarProductosDataTable', 'productosController@listarProductosDataTable');
                }else
                if ($ruta == '/productos/contar') {
                    Route::get('/productos/contar', 'productosController@contar');
                }else
                if ($ruta == '/productos/graficoStockProductos') {
                    Route::get('/productos/graficoStockProductos', 'productosController@graficoStockProductos');
                }else 
                if ($ruta == '/productos/search' && $params) {
                    Route::get('/productos/search/:texto', 'productosController@buscarProducto',$params);
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/productos/guardar') {
                    Route::post('/productos/guardar', 'productosController@guardarProductos');
                }else
                if($ruta == '/productos/guardarCodigo'){
                    Route::post('/productos/guardarCodigo', 'productosController@guardarCodigo');
                }else
                if ($ruta == '/productos/subirFotoProducto') {
                    Route::post('/productos/subirFotoProducto', 'productosController@subirFotoProducto', true);
                }else
                if ($ruta == '/productos/editarProducto') {
                    Route::post('/productos/editarProducto', 'productosController@editarProducto');
                }else
                if ($ruta == '/productos/eliminarProductos') {
                    Route::post('/productos/eliminarProductos', 'productosController@eliminarProductos');
                }else
                if ($ruta == '/productos/updateCampaniaProductos') {
                    Route::post('/productos/updateCampaniaProductos', 'productosController@updateCampaniaProductos');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                } 
                
            break;
        }
    }
}
