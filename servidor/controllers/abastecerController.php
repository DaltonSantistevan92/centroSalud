<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/abastecerModel.php';
require_once 'models/movimientosModel.php';
require_once 'controllers/detalle_abastecerController.php';
require_once 'controllers/inventarioController.php';


class AbastecerController
{
    private $cors;
    private $limite = 6;


    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $requestAbastecer = $request->input('abastecer');
        $requestDetalleAbastecer = $request->input('detalle_abastecer');

        $nuevohelper = new Helper();
        $serie = $nuevohelper->generate_key($this->limite);
        $response = [];

        if ($requestAbastecer) {
            $existeSerie = Abastecer::where('serie', $serie)->get()->first();
            if ($existeSerie) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La serie ya existe',
                    'abastecer' => null,
                ];
            } else {
                $nuevoAbastecer = new Abastecer();
                $nuevoAbastecer->usuarios_id = intval($requestAbastecer->usuarios_id);
                $nuevoAbastecer->proveedores_id = intval($requestAbastecer->proveedores_id);
                $nuevoAbastecer->serie = $serie;
                $nuevoAbastecer->fecha = date('Y-m-d');
                $nuevoAbastecer->estado = 'A';
                
                if ($nuevoAbastecer->save()) { 
                    $detalleAbastecerController = new Detalle_AbastecerController(); 
                    $det_abastecer = $detalleAbastecerController->guardarDetalleAbastecer($nuevoAbastecer->id, $requestDetalleAbastecer);

                    //insertar en la tabla movimientos
                    $nuevoMovimiento = $this->nuevoMovimiento($nuevoAbastecer);

                    //INSERTAR EN LA TABLA INVENTARIO
                    $inventariocontroller = new InventarioController();
                    $responseInventario = $inventariocontroller->guardarIngresoProducto($nuevoMovimiento->id, $requestDetalleAbastecer, 'E');

                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha abastecido correctamente',
                        'abastecer' => $nuevoAbastecer,
                        'detalle_abastecer' => $det_abastecer,
                        'movimientos' => $nuevoMovimiento,
                        'inventario' => $responseInventario
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se puede abastecer',
                        'abastecer' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'abastecer' => $response,
            ];
        }
        echo json_encode($response);
    }

    public function nuevoMovimiento($nuevoAbastecer)
    {
        $nuevMovimiento = new Movimientos();
        $nuevMovimiento->tipo_movimiento = 'E';
        $nuevMovimiento->abastecer_id = $nuevoAbastecer->id;
        $nuevMovimiento->fecha = date('Y-m-d');
        $nuevMovimiento->save();

        return $nuevMovimiento;
    }

    public function listar(){
        $this->cors->corsJson();
        $abastecer = Abastecer::where('estado','A')->orderBy('id','Desc')->get();
        $data = []; $i = 1;

        foreach($abastecer as $ab){
            $proveedor = $ab->proveedores;
            foreach($ab->detalle_abastecer as $dab){
                $producto = $dab->productos;
            }

            $data[] = [
                0 => $i,
                1 => $ab->serie,
                2 => $proveedor->nombre_proveedor,
                3 => $producto->nombre,
                4 => $dab->cantidad,
                5 => $ab->fecha
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

}