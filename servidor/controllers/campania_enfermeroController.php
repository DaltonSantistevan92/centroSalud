<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/campania_enfermeroModel.php';



class Campania_EnfermeroController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listar()
    {
        $this->cors->corsJson();
        $dataCampaniaEnfermero = Campania_Enfermero::where('estado','A')->get();
        $response = [];

        if($dataCampaniaEnfermero){
            foreach($dataCampaniaEnfermero as $ce){
                $ce->campania->cantones;
                $ce->campania->parroquias;
                $ce->campania->barrios;
                $ce->enfermero->personas;
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'campania_enfermero' => $dataCampaniaEnfermero
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No ahi datos',
                'campania_enfermero' => null
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $campaniaEnfermeroRequest = $request->input('campania_enfermero');
        $response = [];

        if($campaniaEnfermeroRequest){
            $campania_id = intval($campaniaEnfermeroRequest->campania_id);
            $enfermero_id = intval($campaniaEnfermeroRequest->enfermero_id);
           
            $nuevoCampaniaEnfernero = new Campania_Enfermero();
            $nuevoCampaniaEnfernero->campania_id = $campania_id;
            $nuevoCampaniaEnfernero->enfermero_id = $enfermero_id;
            $nuevoCampaniaEnfernero->active = 'S';
            $nuevoCampaniaEnfernero->estado = 'A';

            $existe = Campania_Enfermero::where('campania_id',$campania_id)->where('enfermero_id',$enfermero_id)->get()->first();

            if($existe){
                $response = [
                    'status' => false,
                    'mensaje' => 'La campaña y el enfermero ya existen',
                ];
            }else{
                if($nuevoCampaniaEnfernero->save()){
                    //Actualizar la asignacion
                    $dataCampania = Campania::find($campania_id);
                    $dataCampania->asignacion = 'S';
                    $dataCampania->save();

                    //Actualizar la Ocupacion del enfermero
                    $dataEnfermero = Enfermero::find($enfermero_id);
                    $dataEnfermero->ocupado = 'S';
                    $dataEnfermero->save();

                    //actualizar la 
                    $response = [
                        'status' => true,
                        'mensaje' => 'Campaña y enfermero fueron asignados',
                        'campania_enfermero' => $nuevoCampaniaEnfernero,
                    ];
                }else{
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se ha guardado los datos',
                        'campania_enfermero' => null,
                    ];
                }
            }
        }else {
            $response = [
                'status' => false,
                'mensaje' => 'No ha enviado datos',
                'campania_enfermero' => null,
            ];
        }
        echo json_encode($response);
    }

    public function eliminar($params) 
    {
        $this->cors->corsJson(); 
        $id = intval($params['id']);
        $campaniaEnfermero = Campania_Enfermero::find($id);
        $response = [];

        if($campaniaEnfermero){
            $enfermero_id = $campaniaEnfermero->enfermero_id;

            $enfermero = Enfermero::find($enfermero_id);
            $enfermero->ocupado = 'N';
            $enfermero->save();

            if($campaniaEnfermero->delete()){
                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha borrado la asignacion',
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se pudo borrar, intente mas tarde',
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
            ];
        }
        echo json_encode($response);
    }

    public function listarDetalles($params)
    {
        $this->cors->corsJson();
        $campania_id = intval($params['campania_id']);
        $enfermero_id = intval($params['enfermero_id']);
        $active = 'S';
        $response = [];
 
        $data = Campania_Enfermero::where('campania_id',$campania_id)
                                    ->where('enfermero_id',$enfermero_id)
                                    ->where('active',$active)
                                    ->get()->first();

        if($data){
            $enfermero_nombre = $data->enfermero->personas->nombre . ' '. $data->enfermero->personas->apellido;
            $provincia = $data->campania->provincia;
            $canton = $data->campania->cantones;
            $parroquia = $data->campania->parroquias;
            $barrio = $data->campania->barrios;
            $intervalo_de_edad = $data->campania->intervalo_edad->edad;
            $detalleCampania = $data->campania->detalle_campania;

            foreach ($detalleCampania as $key) {
                $prod = $key->productos;

                $aux = [
                    'campania_id' => $data->campania->id,
                    'nombre_campaña' => $data->campania->nombre,
                    'enfermero_id' => $data->enfermero->id,
                    'enfermero' => $enfermero_nombre,
                    'provincia' => $provincia->nombre_provincia,
                    'canton' => $canton->nombre_canton,
                    'parroquia' => $parroquia->nombre_parroquia,
                    'barrio' => $barrio->nombre_barrio,
                    'total_vacuna' => $key->cantidad,
                    'nombre_producto' => $prod->nombre,
                    'intervalo_edad' => $intervalo_de_edad,
                    'producto_id' => $prod->id
                ];
                $dataArray[] = (object)$aux;
            }
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'data' => $dataArray
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'data' => null
            ];
        }
        echo json_encode($response);
    }




}