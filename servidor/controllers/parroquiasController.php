<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/parroquiasModel.php';

class ParroquiasController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listarXidParroquias($params)
    {
        $this->cors->corsJson(); 
        $id = intval($params['id']);
        $response = [];
        
        $parroquias = Parroquias::find($id);
        if ($parroquias) {
            $parroquias->barrios;
            
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'parroquias' => $parroquias
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'parroquias' => null
            ];
        }
        echo json_encode($response);
    }

}
