<?php

require_once 'app/cors.php';
require_once 'core/conexion.php';
require_once 'app/request.php';
require_once 'models/doctor_horarioModel.php';
require_once 'models/horarioModel.php';

class Doctor_HorarioController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    
    public function listarHoraxDia($params)
    {
        $this->cors->corsJson();
        $doctor_id = intval($params['doctor_id']);
        $dia = intval($params['dia']);
        $response = [];
        $dh = Doctor_Horario::where('doctores_id', $doctor_id)->get();

        if(count($dh) > 0){
            foreach ($dh as $key) {
                $aux = [
                    'doctor_id' => $key->doctores->id, 
                    'horario_id' => $key->horario->id,
                    'fecha' => $key->horario->fecha,
                    'hora' => $key->horario->hora_atencion
                ];
                $data[] = (object)$aux;
            }
            
            for ($i=0; $i < count($data) ; $i++) { 
                if($data[$i]->doctor_id === $doctor_id){
                    $h_id[] = $data[$i]->horario_id;
                }  
            }

            if(count($h_id) > 0){
                for ($i=0; $i <count($h_id) ; $i++) { 
                    $diasDisponibles[] = Horario::where('id',$h_id[$i])->whereDay('fecha', $dia)->where('libre', 'S')->get()->first();
                } 

                $arrFinal = array_filter($diasDisponibles);//array_filter elimina vacios
                sort($arrFinal);//Si quieres re-indexar el array final
                
                $response = [
                    'status' => true,
                    'mensaje' => 'existe dia',
                    'dia' =>  $arrFinal
                ];    
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existe el doctor',
                'doctor' => null
            ];
        }
        echo json_encode($response);
    }

    


}