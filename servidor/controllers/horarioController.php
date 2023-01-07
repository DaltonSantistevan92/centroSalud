<?php

require_once 'app/cors.php';
require_once 'core/conexion.php';
require_once 'app/request.php';
require_once 'models/horarioModel.php';
require_once 'models/doctor_horarioModel.php';

class HorarioController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function intervaloHora($hora_inicio, $hora_fin, $intervalo)
    {
        $hora_inicio = new DateTime($hora_inicio);
        $hora_fin = new DateTime($hora_fin);
        $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que nos muestre $hora_fin

        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($hora_inicio > $hora_fin) {
            $hora_fin->modify('+1 day');
        }

        // Establecemos el intervalo en minutos
        $intervalo = new DateInterval('PT' . $intervalo . 'M');

        // Sacamos los periodos entre las horas
        $periodo = new DatePeriod($hora_inicio, $intervalo, $hora_fin);

        foreach ($periodo as $hora) {
            // Guardamos las horas intervalos
            $horas[] = $hora->format('H:i:s');
        }
        return $horas;
    }

    public function guardarHorario(Request $request)
    {
        $this->cors->corsJson();
        $horarioRequest = $request->input('horario');
        $doctorRequest = $request->input('doctor');
        $response = [];

        if($horarioRequest){
            $hora_entrada = $horarioRequest->hora_entrada;
            $hora_salida = $horarioRequest->hora_salida;
            $fecha = $horarioRequest->fecha;
            $intervalo = $horarioRequest->intervalo;

            $doctores_id = intval($doctorRequest->doctores_id); 

           /*  $existeFechaHorario = Horario::where('fecha', $fecha)->get()->first();

            if ($existeFechaHorario) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La fecha ya tiene un horario establecido',
                    'horario' => null,
                ];
            }else{ */
                $horarioArray = $this->intervaloHora($hora_entrada, $hora_salida, $intervalo); //array de horas

                $menosuno = count($horarioArray) - 1;
                for ($i = 0; $i < $menosuno; $i++) {
                    $nuevoHorario = new Horario();
                    $nuevoHorario->hora_entrada = $hora_entrada;
                    $nuevoHorario->hora_salida = $hora_salida;
                    $nuevoHorario->fecha = $fecha;
                    $nuevoHorario->intervalo = $intervalo;
                    $nuevoHorario->hora_atencion = $horarioArray[$i];
                    $nuevoHorario->libre = 'S';
                    $nuevoHorario->estado = 'A';
                    $nuevoHorario->save();

                    $horarioIdArray[] = $nuevoHorario->id; //todos los id de horarios de atencion
                }

                //recuperar el id de horarios y guardar en la tabla Doctor_Horario
                for($j = 0; $j < count($horarioIdArray); $j++){
                    $nuevoDoctorHorario = new Doctor_Horario();
                    $nuevoDoctorHorario->doctores_id = $doctores_id;
                    $nuevoDoctorHorario->horario_id = $horarioIdArray[$j]; 
                    $nuevoDoctorHorario->estado = 'A';
                    $nuevoDoctorHorario->save(); 
                }

                $response = [
                    'status' => true,
                    'mensaje' => 'El horario de atencion se ha guardado corectamente',
                    'horario' => $nuevoHorario,
                    'doctor_horario' => $nuevoDoctorHorario
                ];
           // }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos par procesar',
                'horario_atencion' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarEventoDoctorHorario($params)
    {
        $this->cors->corsJson();
        $doctor_id = intval($params['doctor_id']); 
        $response = [];   $fecha_sistema = date('Y-m-d');
        $doctor_horario = Doctor_Horario::where('doctores_id',$doctor_id)->get();
        

        if(count($doctor_horario) > 0){
            foreach($doctor_horario as $dh){
                $h_id = $dh->horario->id;
                $f = $dh->horario->fecha;
            
                if($f){
                    $dataHorario = Horario::where('id',$h_id)->where('fecha', '>=',$fecha_sistema)
                                        ->where('fecha','>=', $f)->where('libre','S')->where('estado','A')->get();

                    for ($i=0; $i < count($dataHorario) ; $i++) { 
                        $objFecha[] = $dataHorario[$i]->fecha;     
                    }
                }
            }

            $fechasUnicas = array_values(array_unique($objFecha));     $cont = 1; 

            for ($k = 0; $k < count($fechasUnicas); $k++) {
                $colores = $this->colorRandom();

                $aux = [
                    'title' => 'Horario ' . $cont++,
                    'start' => $fechasUnicas[$k],
                    'color' => $colores,
                ];
                $response[] = (object)$aux;
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'El doctor no tiene horario disponible'
            ];
        } 
        echo json_encode($response);
    }

    public function colorRandom() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function eliminarDoctorHorario($params) 
    {
        $this->cors->corsJson(); 
        $horario_id = intval($params['horario_id']);
        $doctor_id = intval($params['doctor_id']);

        $doctor_horario = Doctor_Horario::where('horario_id', $horario_id)->where('doctores_id',$doctor_id)->get()->first();
        $response = [];

        if ($doctor_horario->delete()) {
            //eliminar horario
            $horario = Horario::find($horario_id);
            $horario->delete();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha borrado el horario',
                'horario' => null,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => ' no se pudo borrar, intente mas tarde',
                'horario' => null,
            ];
        }
        echo json_encode($response);
    }

}