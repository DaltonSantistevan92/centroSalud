<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/recetasModel.php';
require_once 'models/productosModel.php';
require_once 'models/citasModel.php';
require_once 'controllers/detalle_recetaController.php';



class RecetasController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardarReceta(Request $request)
    {
        $this->cors->corsJson();
        $recetaRequest = $request->input('receta');
        $detallereceta = $request->input('detalle_receta');
        $response = [];

        if($recetaRequest){
           $citas_id = intval($recetaRequest->citas_id);
           $descripcion = ucfirst($recetaRequest->descripcion);
           $estadoCitaAtendido = 2;

           $nuevaReceta = new Recetas();
           $nuevaReceta->citas_id = $citas_id;
           $nuevaReceta->entregado = 'N';
           $nuevaReceta->fecha = date('Y-m-d');
           $nuevaReceta->descripcion = $descripcion;
           $nuevaReceta->estado = 'A';

            if($nuevaReceta->save()){
                //actualizar a atendido
                $dataCitas = Citas::find($nuevaReceta->citas_id); 
                $dataCitas->estado_cita_id = $estadoCitaAtendido;
                $now = substr(date('H:i:s'), 0, -3);
                $dataCitas->h_salida = $now;
                $dataCitas->save();

                //guarda en detalle receta
                $detallerecetacontroller = new Detalle_RecetaController(); 
                $detReceta = $detallerecetacontroller->guardarDetalleReceta($nuevaReceta->id, $detallereceta);
   
                $response = [
                    'status' => true,
                    'mensaje' => 'La receta se ha guardado correctamente',
                    'receta' => $nuevaReceta,
                    'detalle_receta' => $detReceta,
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'no se pudo guardar la receta',
                    'receta' => null,
                    'detalle_receta' => null,
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos para procesar',
                'receta' => null,
                'detalle' => null,
            ];
        }
        echo json_encode($response);
    }

    public function nuevoMovimiento($nuevaReceta)
    {
        $nuevMovimiento = new Movimientos();
        $nuevMovimiento->tipo_movimiento = 'S';
        $nuevMovimiento->recetas_id = $nuevaReceta->id;
        $nuevMovimiento->fecha = date('Y-m-d');
        $nuevMovimiento->save();

        return $nuevMovimiento;
    }

    public function productoMasEntregado($params)
    {
        $this->cors->corsJson();
        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $limite = intval($params['limite']);

        $dataReceta = Recetas::where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)->where('entregado','S')->take($limite)->get();

        if(count($dataReceta) > 0){
            $producto_receta_id = [];  $prod_Rec_id = [];

            foreach($dataReceta as $rec){
                foreach($rec->detalle_receta as $dre){
                    $aux = [
                        'producto_id' => $dre->productos_id,
                        'cantidad_producto_receta' => $dre->cantidad
                    ];
                    $producto_receta_id[] = (object)$aux;
                    $prod_Rec_id[] = $dre->productos_id;
                }
            }
    
            $norepetidosRecetasProductos = array_values(array_unique($prod_Rec_id));
            $nuevoarrayRecetaProducto = [];  $contadorReceta = 0;
    
            for ($j = 0; $j < count($norepetidosRecetasProductos); $j++) {
                foreach ($producto_receta_id as $prorec) {
                    if ($prorec->producto_id === $norepetidosRecetasProductos[$j]) {
                        $contadorReceta += $prorec->cantidad_producto_receta;
                    }
                }
    
                $auxReceta = [
                    'producto_id' => $norepetidosRecetasProductos[$j],
                    'cantidad_producto_recetas' => $contadorReceta,
                ];
                $contadorReceta = 0;
                $nuevoarrayRecetaProducto[] = (object) $auxReceta;
                $auxReceta = [];
            }
    
            $arrayproductoReceta = $this->ordenarArrayReceta($nuevoarrayRecetaProducto);
            $arrayproductoReceta = Helper::invertir_array($arrayproductoReceta);
    
            $arraysemifinalReceta = [];
            if (count($arrayproductoReceta) < $limite) {
                $arraysemifinalReceta = $arrayproductoReceta;
            } else if (count($arrayproductoReceta) == $limite) {
                $arraysemifinalReceta = $arrayproductoReceta;
            } else if (count($arrayproductoReceta) > $limite) {
                for ($i = 0; $i < $limite; $i++) {
                    $arraysemifinalReceta[] = $arrayproductoReceta[$i];
                }
            }
    
            $arrayfinalReceta = [];
    
            foreach ($arraysemifinalReceta as $afr) {
                $productoReceta = Productos::find($afr->producto_id);
    
                $aux = [
                    'producto' => $productoReceta,
                    'cantidad' => $afr->cantidad_producto_recetas
                ];
                $arrayfinalReceta[] = (object) $aux;
            }
    
            //armar grafico cantidad de  producto mas entregados
            foreach ($arrayfinalReceta as $item2) {
                $labelsReceta[] = $item2->producto->nombre;
                $masEntregadosxReceta[] = $item2->cantidad;
            }
    
            $response = [
                'status' => true,
                'lista_receta' => $arrayfinalReceta,
                'data_receta' => [
                    'masEntregadosxReceta' => $masEntregadosxReceta,
                    'labels_receta' => $labelsReceta
                ] 
            ];
        }else{
            $response = [
                'status' =>false,
                'lista_receta' => null,
                'data_receta' => [
                    'masEntregadosxReceta' => null,
                    'labels_receta' => null
                ] 
            ];
        }
        echo json_encode($response); 
    }

    public function ordenarArrayReceta($array)
    {
        for ($i = 1; $i < count($array); $i++) {
            for ($j = 0; $j < count($array) - $i; $j++) {
                if ($array[$j]->cantidad_producto_recetas > $array[$j + 1]->cantidad_producto_recetas) {
                    $c = $array[$j + 1];
                    $array[$j + 1] = $array[$j];
                    $array[$j] = $c;
                }
            }
        }
        return $array;
    }
}