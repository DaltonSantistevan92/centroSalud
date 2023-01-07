<?php

require_once 'app/cors.php';
require_once 'core/conexion.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'models/enfermeroModel.php';

class EnfermeroController
{

    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    public function listarEnfermeroCampania($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $enfermero = Enfermero::find($id);
        $response = [];

        if($enfermero){
            foreach($enfermero->campania_enfermero as $ce){
                $ce->campania;
            }
        
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'enfermero' => $enfermero,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'enfermero' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listar()
    {
        $this->cors->corsJson();
        $dataEnfermero = Enfermero::where('estado', 'A')->where('ocupado', 'N')->get();
        $response = [];

        if ($dataEnfermero) {
            foreach($dataEnfermero as $d){
                    $d->personas;
            }

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'enfermero' => $dataEnfermero,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'enfermero' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardarEnfermero($enfermero, $persona_id)
    {
        if ($enfermero) {
            $nuevoenfermero = new Enfermero();
            $nuevoenfermero->personas_id = $persona_id;
            $nuevoenfermero->estado = 'A';
            $nuevoenfermero->ocupado = 'N';
            $nuevoenfermero->save();

            return $nuevoenfermero;

        } else {
            return null;
        }
    }

    public function buscarEnfermero($params)
    {
        $this->cors->corsJson();
        $texto = strtolower($params['texto']);
        $response = [];

        $sql = "SELECT e.id, p.cedula, p.nombre, p.apellido, p.num_celular, p.direccion, e.id as enfermero_id FROM personas p 
        INNER JOIN enfermero e ON e.personas_id = p.id 
        WHERE p.estado = 'A' and e.ocupado = 'N' and (p.nombre LIKE '%$texto%' OR p.apellido LIKE '%$texto%')";

        $array = $this->conexion->database::select($sql);

        if ($array) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'enfermero' => $array,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen coincidencias',
                'enfermero' => null,
            ];
        }
        echo json_encode($response);
    }

}