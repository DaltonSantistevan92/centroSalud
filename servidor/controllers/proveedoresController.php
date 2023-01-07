<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/proveedoresModel.php';


class ProveedoresController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardarProveedor(Request $request)
    {
        $this->cors->corsJson();
        $requestProveedor = $request->input("proveedor");
        $ruc = $requestProveedor->ruc;

        if ($requestProveedor) {
            $existeruc = Proveedores::where('ruc', $ruc)->get()->first();

            if ($existeruc) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El ruc del proveedor ya existe',
                    'proveedor' => null,
                ];
            } else {
                $nuevoproveedor = new Proveedores();
                $nuevoproveedor->nombre_proveedor = ucfirst($requestProveedor->nombre_proveedor);
                $nuevoproveedor->ruc = $ruc;
                $nuevoproveedor->correo = $requestProveedor->correo;
                $nuevoproveedor->direccion = $requestProveedor->direccion;
                $nuevoproveedor->telefono = $requestProveedor->telefono;
                $nuevoproveedor->estado = 'A';

                if ($nuevoproveedor->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'El proveedor se ha guardado',
                        'proveedor' => $nuevoproveedor,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El proveedor no se puede guardar',
                        'proveedor' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos para procesar',
                'proveedor' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarDataTableProveedores()
    {
        $this->cors->corsJson();
        $dataProveedor = Proveedores::where('estado', 'A')->get();
        $data = [];  $i = 1;

        foreach ($dataProveedor as $dc) {
            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editarProveedor(' . $dc->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminarProveedor(' . $dc->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $dc->nombre_proveedor,
                2 => $dc->ruc,
                3 => $dc->correo,
                4 => $dc->direccion,
                5 => $dc->telefono,
                6 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];
        echo json_encode($result);
    }

    public function listarxIdProveedores($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $dataProveedor = Proveedores::find($id);
        $response = [];

        if($dataProveedor){
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'proveedor' => $dataProveedor,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'proveedor' => null,
            ];
        }
        echo json_encode($response);
    }

    public  function listarProveedores()
    {
        $this->cors->corsJson();
        $dataProveedor = Proveedores::where('estado', 'A')->get();
        $response = [];

        if ($dataProveedor) {
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'proveedor' => $dataProveedor,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'proveedor' => null,
            ];
        }
        echo json_encode($response);
    }

    public function eliminarProveedor(Request $request)
    {
        $this->cors->corsJson();
        $proveedorRequest = $request->input('proveedores');
        $id = intval($proveedorRequest->id);
        $response = [];

        $proveedor = Proveedores::find($id);
        if ($proveedor) {
            $proveedor->estado = 'I';
            $proveedor->save();

            $response = [
                'status' => true,
                'mensaje' => 'Proveedor ha sido Eliminado',
                'proveedor' => $proveedor
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede eliminar la proveedor',
                'proveedor' => null
            ];
        }
        echo json_encode($response);
    }

    public function editarProveedor(Request $request)
    {
        $this->cors->corsJson();
        $proveedorRequest = $request->input('proveedores');
        $id = intval($proveedorRequest->id);
        $proveedor = Proveedores::find($id);
        $response = [];

        if ($proveedorRequest) {
            if ($proveedor) {
                $proveedor->nombre_proveedor = ucfirst($proveedorRequest->nombre_proveedor);
                $proveedor->ruc = $proveedorRequest->ruc;
                $proveedor->correo = $proveedorRequest->correo;
                $proveedor->direccion = $proveedorRequest->direccion;
                $proveedor->telefono = $proveedorRequest->telefono;
                $proveedor->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado el proveedor',
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado el proveedor',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
            ];
        }
        echo json_encode($response);
    }

    




}