<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/estado_citaModel.php';

class Estado_CitaController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function variosEstados()
    {
        $this->cors->corsJson();

        $estado = Estado_Cita::where('estado','A')->get();
                
        $labels = [];  $data = []; $dataPorcentaje = []; $response = [];

        foreach ($estado as $key) {
            $citas = $key->citas;
            $labels[] = $key->detalle;
            $data[] = count($citas);   
        }

        $suma = 0;
        for ($i=0; $i < count($data); $i++) { 
            $suma += $data[$i];      
        }

        for ($i=0; $i < count($data) ; $i++) { 
            $aux = ((100 * $data[$i] ) / $suma);
            $dataPorcentaje[] = round($aux,2);
        }

        $response = [
            'status' => true,
            'mensaje' =>'Existen datos',
            'datos' => [
                'labels' => $labels,
                'data' => $data,
                'porcentaje'=> $dataPorcentaje
            ]
        ];
        
        echo json_encode($response);
    }



}