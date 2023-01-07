<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/detalle_recetaModel.php';


class Detalle_RecetaController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }
    
    public function guardarDetalleReceta($recetas_id, $detalle = [])
    {
        $response = [];
        if (count($detalle) > 0) {
            foreach ($detalle as $det) {
                $nuevo = new Detalle_Receta();
                $nuevo->recetas_id = intval($recetas_id);
                $nuevo->productos_id = intval($det->productos_id);
                $nuevo->cantidad = intval($det->cantidad);
                $nuevo->save();
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay productos para guardar',
                'detalle_receta' => null,
            ];
        }
        return $response;
    }

}