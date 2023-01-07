<?php

require_once 'app/cors.php';
require_once 'core/conexion.php';
require_once 'app/request.php';
require_once 'models/doctoresModel.php';

class DoctoresController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardardoctor($doctor, $persona_id)
    {
        if ($doctor) {
            $nuevodoctor = new Doctores();
            $nuevodoctor->personas_id = $persona_id;
            $nuevodoctor->estado = 'A';
            $nuevodoctor->save();

            return $nuevodoctor;

        } else {
            return null;
        }
    }

    public function listarDoctor()
    {
        $this->cors->corsJson();
        $dataDoctor = Doctores::where('estado', 'A')->get();
        $response = [];

        if (count($dataDoctor) > 0) {
            foreach ($dataDoctor as $d) {
                $d->personas;
            }
        
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'doctor' => $dataDoctor,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'doctor' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarDoctorEspecialidad($params)
    {
        $this->cors->corsJson();
        $doctor_id = intval($params['id']);
        $dataDoctor = Doctores::find($doctor_id);

        if($dataDoctor){
            foreach($dataDoctor->doctores_especialidad as $item){
                $item->especialidad;
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'doctor' => $dataDoctor,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'doctor' => null,
            ];
        }
        echo json_encode($response);
    }

    public function contar()
    {
        $this->cors->corsJson();
        $dataDoctores = Doctores::where('estado', 'A')->get();
        $response = [];

        if ($dataDoctores) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Doctores',
                'cantidad' => $dataDoctores->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Doctores',
                'cantidad' => 0,
            ];
        }
        echo json_encode($response);
    }


}