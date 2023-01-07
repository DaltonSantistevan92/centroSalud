<?php

require_once 'app/error.php';

class ProveedoresAccion
{
    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/proveedores/listarxId' && $params) {
                    Route::get('/proveedores/listarxId/:id', 'proveedoresController@listarxIdProveedores',$params);
                }else
                if ($ruta == '/proveedores/listarDataTable') {
                    Route::get('/proveedores/listarDataTable', 'proveedoresController@listarDataTableProveedores');
                }else 
                if ($ruta == '/proveedores/listar') {
                    Route::get('/proveedores/listar', 'proveedoresController@listarProveedores');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;

            case 'post':
                if ($ruta == '/proveedores/guardar') {
                    Route::post('/proveedores/guardar', 'proveedoresController@guardarProveedor');
                }else
                if ($ruta == '/proveedores/eliminar') {
                    Route::post('/proveedores/eliminar', 'proveedoresController@eliminarProveedor');
                }else
                if ($ruta == '/proveedores/editar') {
                    Route::post('/proveedores/editar', 'proveedoresController@editarProveedor');
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }
            break;
        }
    }
}
