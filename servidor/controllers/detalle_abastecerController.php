<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/detalle_abastecerModel.php';
require_once 'models/productosModel.php';


class Detalle_AbastecerController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardarDetalleAbastecer($abastecer_id, $detalle = [])
    {
        $response = [];
        if (count($detalle) > 0) {
            foreach ($detalle as $det) {
                $nuevoDetalleAbastecer = new Detalle_Abastecer();
                $nuevoDetalleAbastecer->abastecer_id = intval($abastecer_id);
                $nuevoDetalleAbastecer->productos_id = intval($det->productos_id);
                $nuevoDetalleAbastecer->cantidad = intval($det->cantidad);
                $nuevoDetalleAbastecer->save();               

                $stock = $nuevoDetalleAbastecer->cantidad;
                //actualizar producto
                $this->actualizarProducto(intval($det->productos_id), $stock);
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay productos para guardar',
                'detalle_abastecer' => null,
            ];
        }
        return $response;
    }

    protected function actualizarProducto($productos_id, $stock)
    {
        $producto = Productos::find($productos_id);
        $producto->stock += $stock;
        $producto->save();
    }


}