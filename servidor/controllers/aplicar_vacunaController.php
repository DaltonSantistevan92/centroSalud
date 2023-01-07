<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/aplicar_vacunaModel.php';
require_once 'models/enfermeroModel.php';


class Aplicar_VacunaController
{
    private $cors;
    private $limite = 6;


    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function contarVacunasAplicadas($params)
    {
        $this->cors->corsJson();   $response = [];
        $campania_id = intval($params['campania_id']);
        $sumarVacunas = Aplicar_Vacuna::where('estado','A')
                                    ->where('campania_id', $campania_id)
                                    ->get()->sum('total_aplicadas');

        $total_restante = Aplicar_Vacuna::where('estado','A')->where('campania_id', $campania_id)->get();

        if($sumarVacunas){
            foreach($total_restante as $tr){
                $total_restante = $tr->total_restante;
            }

            $response = [
                'status' => true,
                'mensaje' => 'sumando vacunas',
                'vacuna' => $sumarVacunas,
                'vacuna_restante' => $total_restante
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no hay vacunas',
                'vacuna' => 0,
                'vacuna_restante' => 0
            ];
        }
        echo json_encode($response);
    }

    public function listarDataTableVacunacion()
    {
        $this->cors->corsJson();
        $dataVacunacion = Aplicar_Vacuna::where('estado','A')->orderBy('id','desc')->get();   
        $data = []; $i = 1;

        if($dataVacunacion){
            foreach($dataVacunacion as $dv){
               $dv->enfermero->personas->sexo;
               $dv->campania->provincia;
               $dv->campania->cantones;
               $dv->campania->parroquias;
               $dv->campania->barrios;
               $dv->campania->intervalo_edad;
               $dv->pacientes->personas->sexo;

               foreach($dv->campania->detalle_campania as $dc){
                   $dc->productos;
               }

               $botones = '<div class="text-center">
                                <button  class="btn btn-sm btn-outline-primary" onclick="verCarnetVacunacion(' . $dv->id . ')">
                                    <i class="fas fa-clipboard-list"></i> Ver Carnet
                                </button> 
                            </div>';

                $data[] = [
                    0 => $i,
                    1 => $dv->campania->nombre,
                    2 => $dv->pacientes->personas->nombre . ' ' . $dv->pacientes->personas->apellido,
                    3 => $dc->productos->nombre,
                    4 => $botones,
                ];
                $i++;    
            }
            $result = [
                'sEcho' => 1,
                'iTotalRecords' => count($data),
                'iTotalDisplayRecords' => count($data),
                'aaData' => $data,
            ];
        }
        echo json_encode($result);
    }

    public function listar($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        
        $dataVacuna = Aplicar_Vacuna::find($id);

        if($dataVacuna){
            $dataVacuna->enfermero->personas->sexo;
            $dataVacuna->campania->provincia;
            $dataVacuna->campania->cantones;
            $dataVacuna->campania->parroquias;
            $dataVacuna->campania->barrios;
            $dataVacuna->campania->intervalo_edad;
            $dataVacuna->pacientes->personas->sexo;
            
            foreach($dataVacuna->campania->detalle_campania as $dc){
                $dc->productos;
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'vacuna' => $dataVacuna,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'vacuna' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $vacunaRequest = $request->input('vacunar');
        $response = []; 

        if($vacunaRequest){
            $enfermero_id = intval($vacunaRequest->enfermero_id);
            $campania_id = intval($vacunaRequest->campania_id);
            $pacientes_id = intval($vacunaRequest->pacientes_id);
            $total_vacuna = intval($vacunaRequest->total_vacuna); //5
            $total_restante = intval($vacunaRequest->total_restante); //5 de la copia
            $total_aplicadas = $vacunaRequest->total_aplicadas;//1

            $fecha = date('Y-m-d');
            
            $acum = 0;
            for ($i=0; $i < $total_restante; $i++) { 
                $acum = $total_restante - $total_aplicadas;
            }
            
            $nuevoAplicar = new Aplicar_Vacuna();
            $nuevoAplicar->enfermero_id = $enfermero_id;
            $nuevoAplicar->campania_id = $campania_id;
            $nuevoAplicar->pacientes_id = $pacientes_id;
            $nuevoAplicar->total_vacuna = $total_vacuna;
            $nuevoAplicar->total_aplicadas = $total_aplicadas;
            $nuevoAplicar->total_restante = $acum; 
            $nuevoAplicar->fecha = $fecha;
            $nuevoAplicar->hora = $vacunaRequest->hora;
            $nuevoAplicar->estado = 'A';

            $existePaciente = Aplicar_Vacuna::where('campania_id',$campania_id)->where('pacientes_id',$pacientes_id)->where('fecha', $fecha)->get()->first();

            if($existePaciente){
                $response = [
                    'status' => false,
                    'mensaje' => 'El paciente ya se encuentra vacunado',
                ];
            }else{
                if($nuevoAplicar->save()){
                    $response = [
                        'status' => true,
                        'mensaje' => 'El paciente se ha vacunado',
                        'vacuna' => $nuevoAplicar,
                    ];
                }else{
                    $response = [
                        'status' => false,
                        'mensaje' => 'El paciente no se puede vacunar',
                        'vacuna' => null,
                    ];
                }
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'vacuna' => null,
            ];
        }
        echo json_encode($response);
    }

    public function desocuparEnfermero($params)
    {
        $this->cors->corsJson();
        $enfermero_id = intval($params['enfermero_id']);
        $response = [];

        $dataEnfermero = Enfermero::find($enfermero_id);

        if($dataEnfermero){
            $dataEnfermero->ocupado = 'N';
            $dataEnfermero->save();

            $response = [
                'status' => true,
                'mensaje' => 'El enfermero se ha desocupado',
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'El enfermero no se puede desocupar',
            ];
        }
        echo json_encode($response);
    }

    public function pacienteVacunadoxCampania($params)
    {
        $this->cors->corsJson();
        $campania_id = intval($params['campania_id']);
        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $limite = intval($params['limite']);

        $dataVacuna = Aplicar_Vacuna::where('campania_id',$campania_id)
                                    ->where('fecha', '>=', $inicio)
                                    ->where('fecha', '<=', $fin)
                                    ->take($limite)->get();

        if(count($dataVacuna) > 0){
            $sumarVacunasAplicadas = Aplicar_Vacuna::where('estado','A')
                                    ->where('campania_id', $campania_id)
                                    ->get()->sum('total_aplicadas');

            $campana_id = [];  $camp_id = []; 

            foreach($dataVacuna as $dv){
                $total_vacunas = $dv->total_vacuna;
                $restante = $total_vacunas - $sumarVacunasAplicadas;
                $vacunasAplicadas = $sumarVacunasAplicadas;
                $dosis = $dv->total_aplicadas;//
                $provincia = $dv->campania->provincia->nombre_provincia;
                $canton = $dv->campania->cantones->nombre_canton;
                $parroquia = $dv->campania->parroquias->nombre_parroquia;
                $barrio = $dv->campania->barrios->nombre_barrio;
                $intervaloEdad = $dv->campania->intervalo_edad->edad;

                foreach($dv->campania->detalle_campania as $dc){
                $nombreProducto =  $dc->productos->nombre;
                }
                $aux = [
                    'campania_id' => $dv->campania_id,
                    'pacientes_id' => $dv->pacientes_id,
                    'provincia' => $provincia,
                    'canton' => $canton,
                    'parroquia' => $parroquia,
                    'barrio' => $barrio,
                    'intervalo' => $intervaloEdad, 
                    'restante' => $restante,
                    'aplicadas' => $vacunasAplicadas,
                    'dosis' => $dosis,
                    'total_vacuna' => $total_vacunas,
                    'nombreVacuna' => $nombreProducto
                ];
                $campana_id[] = (object)$aux;
                $camp_id[] = $dv->campania_id;
            }

            $norepetidosCampania_id = array_values(array_unique($camp_id));
            $nuevoarrayCampania = [];  $contador = 0; $totalVacuna = [];  $dosis = []; $paciente_id = [];

            for ($j = 0; $j < count($norepetidosCampania_id); $j++) {
                foreach ($campana_id as $c) {
                    if ($c->campania_id === $norepetidosCampania_id[$j]) {
                        $contador += $c->aplicadas;
                        $totalVacuna = $c->total_vacuna;
                        $totalRestante = $c->restante;
                        $totalAplicada = $c->aplicadas;
                        $nombreVacuna = $c->nombreVacuna;
                        $prov = $c->provincia;
                        $cant = $c->canton;
                        $parro = $c->parroquia;
                        $barr = $c->barrio;
                        $edad = $c->intervalo;

                        $paciente_id[] = $c->pacientes_id;
                        $dosis[] = $c->dosis;
                    }
                }

                $aux = [
                    'campania_id' => $norepetidosCampania_id[$j],
                    //'cantidad_aplicadas' => $contador,
                    'total_aplicadas' => $totalAplicada,
                    'total_vacuna' => $totalVacuna,
                    'total_restante' => $totalRestante,
                    'nombreVacuna' => $nombreVacuna,
                    'provincia' => $prov,
                    'canton' => $cant,
                    'parroquia' => $parro,
                    'barrio' => $barr,
                    'edad' => $edad,
                    'paciente_id' => $paciente_id,
                    'dosis' => $dosis,
                ];
                $contador = 0;
                $nuevoarrayCampania[] = (object)$aux;
                $aux = [];
            }

            $arraysemifinal = [];
            if (count($nuevoarrayCampania) < $limite) {
                $arraysemifinal = $nuevoarrayCampania;
            } else if (count($nuevoarrayCampania) == $limite) {
                $arraysemifinal = $nuevoarrayCampania;
            } else if (count($nuevoarrayCampania) > $limite) {
                for ($i = 0; $i < $limite; $i++) {
                    $arraysemifinal[] = $nuevoarrayCampania[$i];
                }
            }
    
            $arrayfinal = [];

            foreach ($arraysemifinal as $af) {
                $pacientes = Pacientes::find($af->paciente_id);
                foreach($pacientes as $p){
                    $p->personas->sexo;
                }

                $aux = [
                    'pacientes' => $pacientes,
                    'dosis' => $af->dosis
                ];
                $arrayfinal[] = (object) $aux;
            }

            //echo json_encode($arrayfinal); die();

            $new = [];

            foreach($arraysemifinal as $a){
                foreach ($arrayfinal as $key) {
                    $aux2 = [
                        'paciente' => $key->pacientes,
                        'dosis' =>$key->dosis,
                    ]; 
                }


                $campania = Campania::find($a->campania_id);
                $nombreCampania = $campania->nombre;

                $aux = [
                    'nombre_campania' => $nombreCampania,
                    'total_vacuna' => $a->total_vacuna,
                    'total_aplicadas' => $a->total_aplicadas,
                    'cantidad_restante' => $a->total_restante,
                    'nombreProducto' => $a->nombreVacuna,
                    'provincia' => $a->provincia,
                    'canton' => $a->canton,
                    'parroquia' => $a->parroquia,
                    'barrio' => $a->barrio,
                    'edad' => $a->edad,
                    'data_paciente' => $aux2
                ];
                $new[] = (object)$aux;
            }

            $response = [
                'status' => true,
                'mensaje' => 'si hay datos',
                'data' => $new
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'data' => null
            ];
        }
        echo json_encode($response);
    }

    public function progreso($params)
    {
        $this->cors->corsJson();
        $campania_id = intval($params['campania_id']);
        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $response = [];

        $dataVacunaTodas = Aplicar_Vacuna::where('fecha', '>=', $inicio)
                                    ->where('fecha', '<=', $fin)
                                    ->where('estado', 'A')
                                    ->get();

        if ($campania_id == -1) {
            if (count($dataVacunaTodas) > 0) {
                //echo json_encode($sumarVacunasAplicadas); die();
                $campana_id = [];  $camp_id = [];

                foreach($dataVacunaTodas as $dv){
                    $totalVacuna = $dv->total_vacuna;
                    $sumarVacunasAplicadas = $dv->total_aplicadas;
                    $provincia = $dv->campania->provincia->nombre_provincia;
                    $canton = $dv->campania->cantones->nombre_canton;
                    $parroquia = $dv->campania->parroquias->nombre_parroquia;
                    $barrio = $dv->campania->barrios->nombre_barrio;
                    $intervaloEdad = $dv->campania->intervalo_edad->edad;
                    $nombreCampaña = $dv->campania->nombre;
    
                    $aux = [
                        'campania_id' => $dv->campania_id,
                        'nombre_campania' => $nombreCampaña,
                        'provincia' => $provincia,
                        'canton' => $canton,
                        'parroquia' => $parroquia,
                        'barrio' => $barrio,
                        'intervalo' => $intervaloEdad,
                        'total_vacuna' => $totalVacuna,
                        'total_aplicadas' => $sumarVacunasAplicadas
                    ]; 
                    $campana_id[] = (object)$aux;
                    $camp_id[] = $dv->campania_id;
                }

                $norepetidosCampania_id = array_values(array_unique($camp_id));
                $nuevoarrayCampania = []; $totalVacuna = []; 
                $totalRestante = [];
                $totalAplicada = 0;

                for ($j = 0; $j < count($norepetidosCampania_id); $j++) {
                    foreach ($campana_id as $c) {
                        if ($c->campania_id === $norepetidosCampania_id[$j]) {
                            $totalVacuna = $c->total_vacuna;
                            $totalAplicada += $c->total_aplicadas;
                            $totalRestante = $totalVacuna - $totalAplicada;
                            $prov = $c->provincia;
                            $cant = $c->canton;
                            $parro = $c->parroquia;
                            $barr = $c->barrio;
                            $edad = $c->intervalo;
                            $nombre_campania = $c->nombre_campania;
                        }
                    }
                    $aux = [
                        'campania_id' => $norepetidosCampania_id[$j],
                        'nombre_campania' => $nombre_campania,
                        'total_aplicadas' => $totalAplicada,
                        'total_vacuna' => $totalVacuna,
                        'total_restante' => $totalRestante,
                        'provincia' => $prov,
                        'canton' => $cant,
                        'parroquia' => $parro,
                        'barrio' => $barr,
                        'edad' => $edad,
                    ];
                    $nuevoarrayCampania[] = (object)$aux;
                    $aux = [];
                    $totalAplicada = 0;

                }
                $response = [
                    'status' => true,
                    'mensaje' => 'si hay datos',
                    'data' => $nuevoarrayCampania
                ]; 
           }
        }else{
            $dataVacuna = Aplicar_Vacuna::where('campania_id',$campania_id)
                                    ->where('fecha', '>=', $inicio)
                                    ->where('fecha', '<=', $fin)
                                    ->get();

            if(count($dataVacuna) > 0){
                $sumarVacunasAplicadas = Aplicar_Vacuna::where('estado','A')
                                        ->where('campania_id', $campania_id)
                                        ->get()->sum('total_aplicadas');
    
                $campana_id = [];  $camp_id = []; 
    
                foreach($dataVacuna as $dv){
                    $totalVacuna = $dv->total_vacuna;
                    $restante = $totalVacuna - $sumarVacunasAplicadas;
                    $provincia = $dv->campania->provincia->nombre_provincia;
                    $canton = $dv->campania->cantones->nombre_canton;
                    $parroquia = $dv->campania->parroquias->nombre_parroquia;
                    $barrio = $dv->campania->barrios->nombre_barrio;
                    $intervaloEdad = $dv->campania->intervalo_edad->edad;
                    $nombreCampaña = $dv->campania->nombre;
    
                    $aux = [
                        'campania_id' => $dv->campania_id,
                        'nombre_campania' => $nombreCampaña,
                        'provincia' => $provincia,
                        'canton' => $canton,
                        'parroquia' => $parroquia,
                        'barrio' => $barrio,
                        'intervalo' => $intervaloEdad,
                        'total_vacuna' => $totalVacuna,
                        'total_restante' => $restante,
                        'total_aplicadas' => $sumarVacunasAplicadas
                    ]; 
                    $campana_id[] = (object)$aux;
                    $camp_id[] = $dv->campania_id;
                }
    
                $norepetidosCampania_id = array_values(array_unique($camp_id));
                $nuevoarrayCampania = []; $totalVacuna = []; 
                $totalRestante = [];
                for ($j = 0; $j < count($norepetidosCampania_id); $j++) {
                    foreach ($campana_id as $c) {
                        if ($c->campania_id === $norepetidosCampania_id[$j]) {
                            $totalVacuna = $c->total_vacuna;
                            $totalRestante = $c->total_restante;
                            $totalAplicada = $c->total_aplicadas;
                            $prov = $c->provincia;
                            $cant = $c->canton;
                            $parro = $c->parroquia;
                            $barr = $c->barrio;
                            $edad = $c->intervalo;
                            $nombre_campania = $c->nombre_campania;
                        }
                    }
                    $aux = [
                        'campania_id' => $norepetidosCampania_id[$j],
                        'nombre_campania' => $nombre_campania,
                        'total_aplicadas' => $totalAplicada,
                        'total_vacuna' => $totalVacuna,
                        'total_restante' => $totalRestante,
                        //'nombreVacuna' => $nombreVacuna,
                        'provincia' => $prov,
                        'canton' => $cant,
                        'parroquia' => $parro,
                        'barrio' => $barr,
                        'edad' => $edad,
                    ];
                    $nuevoarrayCampania[] = (object)$aux;
                    $aux = [];
                }
    
                $response = [
                    'status' => true,
                    'mensaje' => 'si hay datos',
                    'data' => $nuevoarrayCampania
                ]; 
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'no hay datos',
                    'data' => null
                ]; 
            }
        }
        echo json_encode($response);
    }
}