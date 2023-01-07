<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/pacientesModel.php';
require_once 'controllers/personasController.php';



class PacientesController
{
    private $cors;
    private $personaCntr;


    public function __construct()
    {
        $this->cors = new Cors();
        $this->personaCntr = new PersonasController();

    }

    public function listarPacientesxId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];

        $dataPaciente = Pacientes::find($id);
        if($dataPaciente){
            $dataPaciente->personas->sexo;

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'paciente' => $dataPaciente,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'paciente' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarPacientes()
    {
        $this->cors->corsJson();
        $dataPaciente = Pacientes::where('estado', 'A')->get();
        $response = [];

        if ($dataPaciente) {
            foreach($dataPaciente as $dP){
                $dP->personas->sexo;
            }

            $colleccion = collect($dataPaciente)->sortBy([ ['personas.apellido','asc'] , ['personas.nombre','asc'] ]);

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'paciente' => $colleccion,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'paciente' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarPacientesDataTable()
    {
        $this->cors->corsJson();
        $dataPaciente = Pacientes::where('estado', 'A')->get();
        $data = [];  $i = 1;

        foreach ($dataPaciente as $dp) {
            $personas = $dp->personas;
            $sexo = $dp->personas->sexo;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editarPaciente(' . $dp->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn btn-dark btn-sm" onclick="eliminarPaciente(' . $dp->id . ')">
                                <i class="fa fa-trash fa-lg"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $personas->cedula,
                2 => $personas->nombre,
                3 => $personas->apellido,
                4 => $personas->num_celular,
                5 => $personas->direccion,
                6 => $sexo->tipo,
                7 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];
        echo json_encode($result);

    }

    public function guardarPacientes(Request $request)
    {
        $this->cors->corsJson();
        $dataPersona = $this->personaCntr->guardarPersona($request);
        $objctPersona = (object)$dataPersona;
        $response = [];

        if($objctPersona->status){
            $nuevoPaciente = new Pacientes();
            $nuevoPaciente->personas_id = $objctPersona->persona->id;
            $nuevoPaciente->estado = 'A';

            if($nuevoPaciente->save()){
                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha registrado el paciente',
                    'persona' => $nuevoPaciente->personas->cedula,
                    'paciente' => $nuevoPaciente,
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede registrar el paciente',
                    'paciente' => null,
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => $objctPersona->mensaje,
                'paciente' => null,
            ];
        }
        echo json_encode($response);
    }

    public function eliminarPacientes(Request $request)
    {
        $this->cors->corsJson();
        $pacientesRequest = $request->input('pacientes');
        $id = intval($pacientesRequest->id);
        $response = [];

        $pacientes = Pacientes::find($id);
        if ($pacientes) {
            $pacientes->estado = 'I';
            $pacientes->save();

            $response = [
                'status' => true,
                'mensaje' => 'Paciente ha sido Eliminada',
                'paciente' => $pacientes
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede eliminar la paciente',
                'paciente' => null
            ];
        }
        echo json_encode($response);
    }

    public function editarPacientes(Request $request)
    {
        $this->cors->corsJson();
        $pacienteRequest = $request->input('pacientes');
        
        $id = intval($pacienteRequest->id);
        $persona_id = intval($pacienteRequest->personas_id);
        $sexo_id = intval($pacienteRequest->sexo_id);

        $paciente = Pacientes::find($id); 
        $response = [];

        if($pacienteRequest){
            if($paciente){
                $paciente->personas_id = $persona_id;

                $dataPersona = Personas::find($paciente->personas_id);
                $dataPersona->nombre = ucfirst($pacienteRequest->nombre);
                $dataPersona->apellido = ucfirst($pacienteRequest->apellido);
                $dataPersona->num_celular = $pacienteRequest->num_celular;
                $dataPersona->direccion = $pacienteRequest->direccion;
                $dataPersona->sexo_id = $sexo_id;
                $dataPersona->save();
                $paciente->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'El paciente se ha actualizado correctamente',
                    'paciente' => $paciente,
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el paciente',
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos ',
            ];
        }
        echo json_encode($response);
    }

    public function contar()
    {
        $this->cors->corsJson();
        $dataPaciente = Pacientes::where('estado', 'A')->get();
        $response = [];

        if ($dataPaciente) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Pacientes',
                'cantidad' => $dataPaciente->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Pacientes',
                'cantidad' => 0,
            ];
        }
        echo json_encode($response);
    }


    public function buscarPacientes($params){
        $this->cors->corsJson(); $response = []; 
        $texto = strtolower($params['texto']);

        $pacientes = Pacientes::select('pacientes.id','personas.cedula','personas.nombre','personas.apellido','personas.num_celular',' sexo.tipo')
                            ->where('personas.cedula', 'like', '%' . $texto . '%')
                            ->orWhere('personas.nombre', 'like', '%' . $texto . '%')
                            ->join('personas','pacientes.personas_id','=','personas.id')
                            ->join('sexo','personas.sexo_id','=','sexo.id')
                            ->get();
        
        if (count($pacientes) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Concidencias encontradas',
                'pacientes' => $pacientes
            ];
        }else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay registro',
                'pacientes' => null
            ];
        }
        echo json_encode($response);
    }


}