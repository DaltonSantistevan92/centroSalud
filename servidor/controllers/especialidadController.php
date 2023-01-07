<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/especialidadModel.php';

class EspecialidadController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listar()
    {
        $this->cors->corsJson();
        $dataEspecialidad = Especialidad::where('estado', 'A')->get();
        $response = [];

        if ($dataEspecialidad) {
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'especialidad' => $dataEspecialidad,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'especialidad' => null,
            ];
        }
        echo json_encode($response);
    }

}