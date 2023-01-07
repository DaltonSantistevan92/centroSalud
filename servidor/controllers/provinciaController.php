<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/provinciaModel.php';

class ProvinciaController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listarProvincia()
    {
        $this->cors->corsJson();
        $provincia = Provincia::where('estado', 'A')->get();
        $response = [];

        if ($provincia) {
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'provincia' => $provincia,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'provincia' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarXidProvincia($params)
    {
        $this->cors->corsJson(); 
        $id = intval($params['id']);
        $response = [];
        
        $provincia = Provincia::find($id);
        if ($provincia) {
            $provincia->cantones;
            
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'provincia' => $provincia
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'provincia' => null
            ];
        }
        echo json_encode($response);
    }

}
