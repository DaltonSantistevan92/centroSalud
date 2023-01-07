

<?php

require_once 'app/cors.php';
require_once 'core/conexion.php';
require_once 'app/request.php';
require_once 'models/escala_satisfacionModel.php';

class Escala_SatisfacionController
{

    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listar(){
        $this->cors->corsJson();
        $response = [];

        $dataEscalaSatisfacion = Escala_Satisfacion::where('estado','A')->where('id','<>',1)->get();

        if($dataEscalaSatisfacion){
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'escala' => $dataEscalaSatisfacion
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'escala' => []
            ];
        }
        echo json_encode($response);
    }


}