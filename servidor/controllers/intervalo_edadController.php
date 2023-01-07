<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/intervalo_edadModel.php';

class Intervalo_EdadController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listarIntervaloEdad()
    {
        $this->cors->corsJson();
        $intervalo = Intervalo_Edad::where('estado', 'A')->get();
        $response = [];

        if ($intervalo) {
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'intervalo' => $intervalo,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'intervalo' => null,
            ];
        }
        echo json_encode($response);
    }

   
}
