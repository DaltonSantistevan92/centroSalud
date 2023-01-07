<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/detalle_campaniaModel.php';
require_once 'models/productosModel.php';


class Detalle_CampaniaController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardarDetalleCampania($campania_id, $detalle = [])
    {
        $response = [];
        if (count($detalle) > 0) {
            foreach ($detalle as $det) {
                $nuevoDetalleCampania = new Detalle_Campania();
                $nuevoDetalleCampania->campania_id = intval($campania_id);
                $nuevoDetalleCampania->productos_id = intval($det->productos_id);
                $nuevoDetalleCampania->cantidad = intval($det->cantidad);
                $nuevoDetalleCampania->save();               

                $stock = $nuevoDetalleCampania->cantidad * (-1);
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