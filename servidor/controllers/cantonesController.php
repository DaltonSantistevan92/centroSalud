<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/cantonesModel.php';

class CantonesController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listarXidCantones($params)
    {
        $this->cors->corsJson(); 
        $id = intval($params['id']);
        $response = [];
        
        $cantones = Cantones::find($id);
        if ($cantones) {
            $cantones->parroquias;
            
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'cantones' => $cantones
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'cantones' => null
            ];
        }
        echo json_encode($response);
    }

}
