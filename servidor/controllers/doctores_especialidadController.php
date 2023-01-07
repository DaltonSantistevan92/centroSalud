<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/doctores_especialidadModel.php';
require_once 'models/especialidadModel.php';


class Doctores_EspecialidadController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listar()
    {
        $this->cors->corsJson();
        $dataDoctorEspecialidad = Doctores_Especialidad::where('estado','A')->get();
        $response = [];

        if($dataDoctorEspecialidad){
            foreach($dataDoctorEspecialidad as $de){
                $de->doctores->personas->sexo;
                $de->especialidad;
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'doctores_especialidad' => $dataDoctorEspecialidad
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No ahi datos',
                'doctores_especialidad' => null
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $doctorEspecialidadRequest = $request->input('doctores_especialidad');
        $response = [];

        if($doctorEspecialidadRequest){
            $doctores_id = intval($doctorEspecialidadRequest->doctores_id);
            $especialidad_id = intval($doctorEspecialidadRequest->especialidad_id);
           
            $nuevoDoctorEspecialidad = new Doctores_Especialidad();
            $nuevoDoctorEspecialidad->doctores_id = $doctores_id;
            $nuevoDoctorEspecialidad->especialidad_id = $especialidad_id;
            $nuevoDoctorEspecialidad->estado = 'A';

            $existe = Doctores_Especialidad::where('doctores_id',$doctores_id)->where('especialidad_id',$especialidad_id)->get()->first();

            if($existe){
                $response = [
                    'status' => false,
                    'mensaje' => 'El doctor ya tiene su especialidad',
                ];
            }else{
                if($nuevoDoctorEspecialidad->save()){
                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha asignado la especialidad',
                        'doctor_especialidad' => $nuevoDoctorEspecialidad,
                    ];
                }else{
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se ha guardado los datos',
                        'doctor_especialidad' => null,
                    ];
                }
            }
        }else {
            $response = [
                'status' => false,
                'mensaje' => 'No ha enviado datos',
                'doctor_especialidad' => null,
            ];
        }
        echo json_encode($response);
    }

    public function eliminarDoctorEspecialidad($params) 
    {
        $this->cors->corsJson(); 
        $id = intval($params['id']);
        $docEsp = Doctores_Especialidad::find($id);
        $response = [];

        if($docEsp->delete()){
            $response = [
                'status' => true,
                'mensaje' => 'Se ha borrado la asignacion de la especialidad',
            ];
        }else {
            $response = [
                'status' => false,
                'mensaje' => 'No se pudo borrar, intente mas tarde',
            ];
        }
        echo json_encode($response);
    }



}