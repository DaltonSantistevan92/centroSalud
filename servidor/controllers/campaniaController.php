<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/campaniaModel.php';
require_once 'controllers/detalle_campaniaController.php';
require_once 'models/movimientosModel.php';
require_once 'controllers/inventarioController.php';

class CampaniaController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }


    public function listar()
    {
        $this->cors->corsJson();
        $dataCampania = Campania::where('estado', 'A')->get();
        $response = [];

        if ($dataCampania) {
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'campania' => $dataCampania,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'campania' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $campaniaRequest = $request->input('campania');
        $detalleCampania = $request->input('detalle_campania');
        $response = [];

        if ($campaniaRequest) {
            $nombre = ucfirst($campaniaRequest->nombre);
            $provincia_id = intval($campaniaRequest->provincia_id);
            $cantones_id = intval($campaniaRequest->cantones_id);
            $parroquias_id = intval($campaniaRequest->parroquias_id);
            $barrios_id = intval($campaniaRequest->barrios_id);
            $intervalo_edad_id = intval($campaniaRequest->intervalo_edad_id);

            $nuevaCampania = new Campania();
            $nuevaCampania->nombre = $nombre;
            $nuevaCampania->provincia_id = $provincia_id;
            $nuevaCampania->cantones_id = $cantones_id;
            $nuevaCampania->parroquias_id = $parroquias_id;
            $nuevaCampania->barrios_id = $barrios_id;
            $nuevaCampania->intervalo_edad_id = $intervalo_edad_id;
            $nuevaCampania->fecha = $campaniaRequest->fecha;
            $nuevaCampania->asignacion = 'N';
            $nuevaCampania->estado = 'A';

            if ($nuevaCampania->save()) {
                //guarda en detalle campania
                $detalleCampaniacontroller = new Detalle_CampaniaController();
                $detCampania = $detalleCampaniacontroller->guardarDetalleCampania($nuevaCampania->id, $detalleCampania);

                //insertar en la tabla movimiento
                $nuevoMovimiento = $this->nuevoMovimiento($nuevaCampania);

                //INSERTAR EN LA TABLA INVENTARIO
                $inventariocontroller = new InventarioController();
                $responseInventario = $inventariocontroller->guardarIngresoProducto($nuevoMovimiento->id, $detalleCampania, 'S');

                
                $response = [
                    'status' => true,
                    'mensaje' => 'La campaña se ha guardado correctamente',
                    'campania' => $nuevaCampania,
                    'detalle' => $detCampania,
                    'movimiento' => $nuevoMovimiento,
                    'inventario' => $responseInventario
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'no se pudo guardar la campaña',
                    'campania' => null,
                    'detalle' => null,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos para procesar',
                'campania' => null,
                'detalle' => null,
            ];
        }
        echo json_encode($response);
    }

    public function nuevoMovimiento($nuevaCampania)
    {
        $nuevMovimiento = new Movimientos();
        $nuevMovimiento->tipo_movimiento = 'S';
        $nuevMovimiento->campania_id = $nuevaCampania->id;
        $nuevMovimiento->fecha = date('Y-m-d');
        $nuevMovimiento->save();

        return $nuevMovimiento;
    }

    public function buscarCampania($params)
    {
        $this->cors->corsJson();
        $texto = strtolower($params['texto']);
        $text = str_replace('%20', ' ', $texto);
        $response = [];

        $campania = Campania::where('nombre','like',$text . '%')->where('estado','A')->get();
        if (count($campania) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'campania' => $campania,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen coincidencias',
                'campania' => null,
            ];
        }
        echo json_encode($response);
    }
}
