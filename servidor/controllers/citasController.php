<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'core/conexion.php';
require_once 'models/citasModel.php';
require_once 'models/recetasModel.php';
require_once 'models/horarioModel.php';
require_once 'models/productosModel.php';
require_once 'models/movimientosModel.php';
require_once 'models/estado_citaModel.php';
require_once 'controllers/inventarioController.php';

class CitasController 
{
    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();

    }

    public function listarCitasXId($params)
    {
        $this->cors->corsJson();
        $citas_id = intval($params['id']);
        $citas = Citas::find($citas_id);
        $response = [];

        if ($citas) {
            $citas->doctores->personas;
            $citas->pacientes->personas;
            $citas->especialidad;
            $citas->estado_cita;
            $citas->horario;

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'citas' => $citas,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'citas' => null,
            ];
        }
        echo json_encode($response);
    }

    public function updateEntrada($params)
    {
        $this->cors->corsJson();
        $citas_id = intval($params['id']);
        $citas = Citas::find($citas_id);
        $response = [];

        if ($citas) {
            if($citas->h_entrada !== null ){ return; }
            $now = substr(date('H:i:s'), 0, -3);
            $citas->h_entrada = $now;
            $citas->save();

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'citas' => $citas,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'citas' => null,
            ];
        }
        echo json_encode($response);
    }

    public function verCitasAtendidas($params)
    {
        $this->cors->corsJson();
        $citas_id = intval($params['id']);
        $citas = Citas::find($citas_id);
        $response = [];

        if ($citas) {
            $citas->doctores->personas->sexo;
            $citas->pacientes->personas->sexo;
            $citas->especialidad;
            $citas->estado_cita;
            $citas->horario;

            foreach($citas->recetas as $r){
                foreach($r->detalle_receta as $dr){
                    $dr->productos->categorias;
                }
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'citas' => $citas,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'citas' => null,
            ];
        }
        echo json_encode($response);
    }

    public function verCitasEntregadas($params)
    {
        $this->cors->corsJson();
        $citas_id = intval($params['id']);
        $citas = Citas::find($citas_id);
        $response = [];

        if ($citas) {
            $citas->doctores->personas->sexo;
            $citas->pacientes->personas->sexo;
            $citas->especialidad;
            $citas->estado_cita;
            $citas->horario;

            foreach($citas->recetas as $r){
                foreach($r->detalle_receta as $dr){
                    $dr->productos->categorias;
                }
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'citas' => $citas,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'citas' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardarCita(Request $request)
    {
        $this->cors->corsJson();
        $citaRequest = $request->input('cita');
        $response = [];

        if($citaRequest){
            $nuevaCita = new Citas();
            $nuevaCita->usuarios_id = intval($citaRequest->usuarios_id);
            $nuevaCita->doctores_id = intval($citaRequest->doctores_id);
            $nuevaCita->horario_id = intval($citaRequest->horario_id);
            $nuevaCita->especialidad_id = intval($citaRequest->especialidad_id);
            $nuevaCita->pacientes_id = intval($citaRequest->pacientes_id);
            $nuevaCita->estado_cita_id = 1;
            $nuevaCita->escala_satisfacion_id = 1;  //default
            $nuevaCita->fecha = $citaRequest->fecha;
            $nuevaCita->estado = 'A';

            $existeHorario = Citas::where('doctores_id',intval($citaRequest->doctores_id))
                                    ->where('pacientes_id',intval($citaRequest->pacientes_id))
                                    ->where('fecha',$citaRequest->fecha)->get()->first();

            if($existeHorario){
                $response = [
                    'status' => false,
                    'mensaje' => 'Existe una cita programada para este paciente ',
                ];
            }else{
                if($nuevaCita->save()){

                    //actualizar la hora a ocupado
                    $actualizarHora = Horario::find(intval($citaRequest->horario_id));
                    $actualizarHora->libre = 'O';
                    $actualizarHora->save();

                    $response = [
                        'status' => true,
                        'mensaje' => 'La cita se guardo correctamente',
                        'cita' => $nuevaCita,
                    ];
                }else{
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se puede guardar la cita',
                        'cita' => null,
                    ];
                }
            }

        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'cita' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarCitasDataTable()
    {
        $this->cors->corsJson();
        $dataCitas = Citas::where('estado', 'A')->orderBy('id','desc')->get();
        $data = []; $i = 1;

        foreach($dataCitas as $dc){
            $usuario = $dc->usuarios->personas;
            $doctor = $dc->doctores->personas;
            $horario = $dc->horario;
            $especialidad = $dc->especialidad;
            $paciente = $dc->pacientes->personas;
            $estadoCita = $dc->estado_cita;
            $dataFechaCita = $dc->horario->fecha;

            //substr para quitar los ceros de la derecha
            $horario = substr($horario->hora_atencion, 0, -3);
            $estado = $dc->estado_cita_id;

            $other = $dc->estado_cita_id == 1 ? 2 : 1;
            $disabled = $dc->estado_cita_id == 2 ? 'disabled' : ' ';
            $disabledCancelar = $dc->estado_cita_id == 3 ? 'disabled' : ' ';
            $disabledCancelarEntregado = $dc->estado_cita_id == 4 ? 'disabled' : ' ';

            if ($estado == 1) {//pendiente
                $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $estadoCita->detalle . '</span>';
            } else if ($estado == 2) {//atendido
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $estadoCita->detalle . '</span>';
            }else if ($estado == 3) {//cancelado
                $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $estadoCita->detalle . '</span>';
            } else {//entregado
                $estado = '<span class="badge bg-dark" style="font-size: 1rem;">' . $estadoCita->detalle . '</span>';
            }

            $botones = '<div class="text-center">
                            <button  class="btn btn-sm btn-outline-primary" onclick="verCita(' . $dc->id . ')">
                                <i class="fas fa-clipboard-list"></i> Ver Cita
                            </button>

                            <button ' . $disabled . ' ' . $disabledCancelar . ' ' .$disabledCancelarEntregado .' class="btn btn-sm btn-outline-dark" onclick="cancelarCita(' . $dc->id . ',' . $other . ')">
                                <i class="fas fa-times"></i> Cancelar Cita
                            </button> 
                        </div>';

            $data[] = [
                0 => $i,
                1 => $usuario->nombre . ' ' . $usuario->apellido,
                2 => $doctor->nombre . ' ' . $doctor->apellido,
                3 => $especialidad->especialidad,
                4 => $paciente->nombre . ' ' . $paciente->apellido,
                5 => $dataFechaCita,
                6 => $horario,
                7 => $estado,
                8 => $botones,
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

    public function listarCitasCanceladasxDoctor($params)
    {
        $this->cors->corsJson();
        $personas_id = intval($params['personas_id']);
        $estado_cita_id = intval($params['estado_cita_id']);
        $result = [];

        $dataDoctor = Doctores::where('estado', 'A')->where('personas_id', $personas_id)->get()->first();

        if($dataDoctor){
            $doctores_id = $dataDoctor->id;
            //CitasCancelada x doctor
            $citasPendientes = Citas::where('doctores_id',$doctores_id)
                                    ->where('estado_cita_id',$estado_cita_id)
                                    ->where('estado','A')
                                    ->orderBy('id','Desc')
                                    ->get();
            $data = [];  $i = 1;

            foreach($citasPendientes as $cp){
                $paciente = $cp->pacientes->personas;
                $sexo = $cp->pacientes->personas->sexo;
                $horario = $cp->horario;
                $estado_cita = $cp->estado_cita;

                $estado = $cp->estado_cita_id;

                if ($estado == 3) {
                    $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $estado_cita->detalle . '</span>';
                }

                $botones = '<div class="text-center">
                                <button  class="btn btn-sm btn-outline-primary" onclick="verCita(' . $cp->id . ')">
                                    <i class="fas fa-clipboard-list"></i> Ver Cita
                                </button> 
                            </div>';

                $data[] = [
                    0 => $i,
                    1 => $paciente->nombre . ' ' . $paciente->apellido,
                    2 => $sexo->tipo,
                    3 => $horario->fecha,
                    4 => substr($horario->hora_atencion,0,-3),
                    5 => $estado,
                    6 => $botones,
                ];
                $i++;

            }

            $result = [
                'sEcho' => 1,
                'iTotalRecords' => count($data),
                'iTotalDisplayRecords' => count($data),
                'aaData' => $data,
            ];
        }else{
            $result = [
                'status' => false,
                'mensaje' => 'No ahi doctor',
            ];
        }
        echo json_encode($result);

    }

    public function cancelarCitaXId($params)
    {
        $this->cors->corsJson();
        $cita_id = intval($params['id']);
        $estado_cita_id = intval($params['estado_cita_id']); //3 cancelado
        $response = [];
        $cita = Citas::find($cita_id);

        if ($cita) {
            $h_id = $cita->horario_id;
            $cita->estado_cita_id = $estado_cita_id;
            $cita->save();

            $horario = Horario::find($h_id);
            $horario->libre = 'S';
            $horario->save();

            $response = [
                'status' => true,
                'mensaje' => 'La cita ha sido cancelada',
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede cancelar la cita',
            ];
        }
        echo json_encode($response);
    }

    public function listarCitasPendientesDataTable2($params)
    {
        $this->cors->corsJson();
        $personas_id = intval($params['personas_id']);
        $estado_cita_id = intval($params['estado_cita_id']);
        $result = [];

        $dataDoctor = Doctores::where('estado', 'A')->where('personas_id', $personas_id)->get()->first();

        if($dataDoctor){
            $doctores_id = $dataDoctor->id;
            //CitasPendientes
            $citasPendientes = Citas::where('doctores_id',$doctores_id)
                                    ->where('estado_cita_id',$estado_cita_id)
                                    ->where('estado','A')
                                    ->orderBy('id','asc')
                                    ->get();
            $data = [];  $i = 1;

            foreach($citasPendientes as $cp){
                $paciente = $cp->pacientes->personas;
                $sexo = $cp->pacientes->personas->sexo;
                $horario = $cp->horario;
                $estado_cita = $cp->estado_cita;

                $estado = $cp->estado_cita_id;
                $other = $cp->estado_cita_id == 1 ? 3 : 1;

                if ($estado == 1) {
                    $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $estado_cita->detalle . '</span>';
                } else if ($estado == 2) {
                    $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $estado_cita->detalle . '</span>';
                } else {
                    $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $estado_cita->detalle . '</span>';
                }

        
                $botones = '<div class="text-center">
                            <button  class="btn btn-sm btn-outline-primary" onclick="atenderCita(' . $cp->id . ')">
                                <i class="fas fa-clipboard-list"></i> Atender Cita
                            </button>

                            <button class="btn btn-sm btn-outline-dark" onclick="cancelarCita(' . $cp->id . ',' . $other . ')">
                                <i class="fas fa-times"></i> Cancelar Cita
                            </button> 
                        </div>';


                $data[] = [
                    0 => $i,
                    1 => $paciente->nombre . ' ' . $paciente->apellido,
                    2 => $sexo->tipo,
                    3 => $horario->fecha,
                    4 => substr($horario->hora_atencion,0,-3),
                    5 => $estado,
                    6 => $botones,
                ];
                $i++;

            }

            $result = [
                'sEcho' => 1,
                'iTotalRecords' => count($data),
                'iTotalDisplayRecords' => count($data),
                'aaData' => $data,
            ];
        }else{
            $result = [
                'status' => false,
                'mensaje' => 'No ahi doctor',
            ];
        }
        echo json_encode($result);
    }

    public function listarCitasPendientesDataTable($params) 
    { 
        $this->cors->corsJson();
        $personas_id = intval($params['personas_id']);
        $estado_cita_id = intval($params['estado_cita_id']);
        $result = [];

        $dataDoctor = Doctores::where('estado', 'A')->where('personas_id', $personas_id)->get()->first();

        if($dataDoctor){
            $doctores_id = $dataDoctor->id;
            //CitasPendientes
            $citasPendientes = Citas::join('horario', 'horario_id', 'horario.id')
                                    ->where('citas.estado','A')
                                    ->where('doctores_id',$doctores_id)
                                    ->where('estado_cita_id',$estado_cita_id)
                                    ->orderBy('horario.hora_atencion','ASC')
                                    ->orderBy('horario.fecha','ASC')
                                    ->get(['citas.id','citas.estado_cita_id','citas.pacientes_id','citas.horario_id']);   
                                    $data = [];  $i = 1;

            foreach($citasPendientes as $cp){
                $paciente = $cp->pacientes->personas; 
                $sexo = $cp->pacientes->personas->sexo;
                $horario = $cp->horario;
                $estado_cita = $cp->estado_cita;
                
                $estado = $cp->estado_cita_id;
                                          
                $other = $cp->estado_cita_id == 1 ? 3 : 1;

                if ($estado == 1) {
                    $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $estado_cita->detalle . '</span>';
                } else if ($estado == 2) {
                    $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $estado_cita->detalle . '</span>';
                } else {
                    $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $estado_cita->detalle . '</span>';
                }

                $botones = '<div class="text-center">
                            <button  class="btn btn-sm btn-outline-primary" onclick="atenderCita(' . $cp->id . ')">
                                <i class="fas fa-clipboard-list"></i> Atender Cita
                            </button>

                            <button class="btn btn-sm btn-outline-dark" onclick="cancelarCita(' . $cp->id . ',' . $other . ')">
                                <i class="fas fa-times"></i> Cancelar Cita
                            </button> 
                        </div>';

                $data[] = [
                    0 => $i,
                    1 => $paciente->nombre . ' ' . $paciente->apellido,
                    2 => $sexo->tipo,
                    3 => $horario->fecha,
                    4 => substr($horario->hora_atencion,0,-3),
                    5 => $estado,
                    6 => $botones,
                ];
                $i++;
            }

            $result = [
                'sEcho' => 1,
                'iTotalRecords' => count($data),
                'iTotalDisplayRecords' => count($data),
                'aaData' => $data,
            ];
        }else{
            $result = [
                'status' => false,
                'mensaje' => 'No ahi doctor',
            ];
        }
        echo json_encode($result);
    }

    public function cancelarxDoctor($params) 
    {
        $this->cors->corsJson();
        $cita_id = intval($params['id']);
        $estado_cita_id = intval($params['estado_cita_id']); //3 cancelado
        $response = [];

        $cita = Citas::find($cita_id);

        if ($cita) {
            $cita->estado_cita_id = $estado_cita_id;
            $cita->save();

            $response = [
                'status' => true,
                'mensaje' => 'La cita ha sido cancelada',
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede cancelar la cita',
            ];
        }
        echo json_encode($response);
    }

    public function listarCitasAtendidasxDoctor($params)
    {
        $this->cors->corsJson();
        $personas_id = intval($params['personas_id']);
        $estado_cita_id = intval($params['estado_cita_id']);
        $result = [];

        $dataDoctor = Doctores::where('estado', 'A')->where('personas_id', $personas_id)->get()->first();

        if($dataDoctor){
            $doctores_id = $dataDoctor->id;
            //CitasAtendida x doctor
            $citasPendientes = Citas::where('doctores_id',$doctores_id)
                                    ->where('estado_cita_id',$estado_cita_id)
                                    ->where('estado','A')
                                    ->orderBy('id','Desc')
                                    ->get();
            $data = [];  $i = 1;

            foreach($citasPendientes as $cp){
                $paciente = $cp->pacientes->personas;
                $sexo = $cp->pacientes->personas->sexo;
                $horario = $cp->horario;
                $estado_cita = $cp->estado_cita;

                $estado = $cp->estado_cita_id;

                if ($estado == 2) {
                    $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $estado_cita->detalle . '</span>';
                }

                $botones = '<div class="text-center">
                                <button  class="btn btn-sm btn-outline-primary" onclick="verCita(' . $cp->id . ')">
                                    <i class="fas fa-clipboard-list"></i> Ver Cita
                                </button> 
                            </div>';

                $data[] = [
                    0 => $i,
                    1 => $paciente->nombre . ' ' . $paciente->apellido,
                    2 => $sexo->tipo,
                    3 => $horario->fecha,
                    4 => substr($horario->hora_atencion,0,-3),
                    5 => $estado,
                    6 => $botones,
                ];
                $i++;

            }

            $result = [
                'sEcho' => 1,
                'iTotalRecords' => count($data),
                'iTotalDisplayRecords' => count($data),
                'aaData' => $data,
            ];
        }else{
            $result = [
                'status' => false,
                'mensaje' => 'No ahi doctor',
            ];
        }
        echo json_encode($result);


    }

    public function listarCitasAtendidaPeroNoEntregada()
    {
        $this->cors->corsJson();
        $citaAtendido = 2;
        $dataCitas = Citas::where('estado', 'A')->where('estado_cita_id',$citaAtendido)->orderBy('id','desc')->get();
        $data = []; $i = 1;

        foreach($dataCitas as $dc){
            $usuario = $dc->usuarios->personas;
            $doctor = $dc->doctores->personas;
            $horario = $dc->horario;
            $especialidad = $dc->especialidad;
            $paciente = $dc->pacientes->personas;
            $estadoCita = $dc->estado_cita;
            $dataFechaCita = $dc->horario->fecha;

            foreach($dc->recetas as $r){
                $entr = $r->entregado;
            }

            $No = 'No';  $Si = 'Si';
            if($entr == 'N'){
                $estadoEntr = '<span class="badge bg-danger" style="font-size: 1rem;">' . $No . '</span>';
            }else{
                $estadoEntr = '<span class="badge bg-primary" style="font-size: 1rem;">' . $Si . '</span>';
            }

            //substr para quitar los ceros de la derecha
            $horario = substr($horario->hora_atencion, 0, -3);
            $estado = $dc->estado_cita_id;

            if ($estado == 2) {//atendido
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $estadoCita->detalle . '</span>';
            }

            $other = $dc->estado_cita_id == 2 ? 4 : '';
            $disabled = $dc->estado_cita_id == 4 ? 'disabled' : '';
            $disabledEntregado = $dc->estado_cita_id == 4 ? 'disabled' : ' ';

            $botones = '<div class="text-center">
                            <button ' . $disabled . ' ' . $disabledEntregado . ' class="btn btn-sm btn-outline-primary" onclick="entregaProducto(' . $dc->id . ',' . $other . ')">
                                <i class="fas fa-check"></i> Entregar
                            </button> 
                        </div>';

            $data[] = [
                0 => $i,
                1 => $usuario->nombre . ' ' . $usuario->apellido,
                2 => $doctor->nombre . ' ' . $doctor->apellido,
                3 => $especialidad->especialidad,
                4 => $paciente->nombre . ' ' . $paciente->apellido,
                5 => $dataFechaCita,
                6 => $horario,
                7 => $estadoEntr,
                8 => $estado,
                9 => $botones,
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

    public function listarCitasEntregada()
    {
        $this->cors->corsJson();
        $citaEntregado = 4;
        $dataCitas = Citas::where('estado', 'A')->where('estado_cita_id',$citaEntregado)->orderBy('id','desc')->get();
        $data = []; $i = 1;

        foreach($dataCitas as $dc){
            $usuario = $dc->usuarios->personas;
            $doctor = $dc->doctores->personas;
            $horario = $dc->horario;
            $especialidad = $dc->especialidad;
            $paciente = $dc->pacientes->personas;
            $estadoCita = $dc->estado_cita;
            $dataFechaCita = $dc->horario->fecha;

            foreach($dc->recetas as $r){
                $entr = $r->entregado;
            }

            $Si = 'Si';
            if($entr == 'S'){
                $estadoEntr = '<span class="badge bg-primary" style="font-size: 1rem;">' . $Si . '</span>';
            }

            //substr para quitar los ceros de la derecha
            $horario = substr($horario->hora_atencion, 0, -3);
            $estado = $dc->estado_cita_id;

            if ($estado == 4) {//atendido
                $estado = '<span class="badge bg-dark" style="font-size: 1rem;">' . $estadoCita->detalle . '</span>';
            }

            $botones = '<div class="text-center">
                            <button class="btn btn-sm btn-outline-primary" onclick="verProductoEntregados(' . $dc->id . ')">
                                <i class="fas fa-eye"></i> 
                            </button> 
                        </div>';

            $data[] = [
                0 => $i,
                1 => $usuario->nombre . ' ' . $usuario->apellido,
                2 => $doctor->nombre . ' ' . $doctor->apellido,
                3 => $especialidad->especialidad,
                4 => $paciente->nombre . ' ' . $paciente->apellido,
                5 => $dataFechaCita,
                6 => $horario,
                7 => $estadoEntr,
                8 => $estado,
                9 => $botones
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

    public function entregaProductoxRecetaMovimientoInventario($params) //no tocar
    {
        $this->cors->corsJson();
        $cita_id = intval($params['cita_id']);
        $estado_cita_id = intval($params['estado_cita_id']);//entregado = 4
        $escala_satifacion_id = intval($params['satisfacion_id']);
        $response = []; $nuevoMovimiento = null;

        $dataCita = Citas::find($cita_id);//esta bien

        if($dataCita){
            $dataCita->estado_cita_id = $estado_cita_id;
            $dataCita->escala_satisfacion_id = $escala_satifacion_id;
            $dataCita->save();
            
            $unaSolaReceta = Recetas::where('citas_id', $dataCita->id)->first(); //esta bien
            //empieza
            if($unaSolaReceta){
                $recetas_id = intval($unaSolaReceta->id);
                $unaSolaReceta->entregado = 'S';
                $unaSolaReceta->save();
               
                //insertar en la tabla movimientos
                $nuevoMovimiento = new Movimientos();
                $nuevoMovimiento->tipo_movimiento = 'S';
                $nuevoMovimiento->recetas_id = $recetas_id;
                $nuevoMovimiento->fecha = date('Y-m-d');
                $nuevoMovimiento->save();
                    
                $detalleReceta = $unaSolaReceta->detalle_receta;
                

                foreach($detalleReceta as $dr){ 
                    $producto_id = intval($dr->productos_id); 
                    $aux = intval($dr->cantidad);
                    $cantidad = ((-1) * $aux);
                    
                    $this->actualizarStockProducto(intval($dr->productos_id), $cantidad);

                    $ultimo = Inventario::where('productos_id', intval($dr->productos_id))->orderBy('id', 'DESC')->get()->first();
    
                    $nuevo = new Inventario();
                    $nuevo->productos_id = $producto_id;
                    $nuevo->movimientos_id = intval($nuevoMovimiento->id);
                    $nuevo->tipo = 'S';
                    $nuevo->cantidad = $cantidad;

                    $cant = intval( $ultimo->cantidad_disponible ) + intval( $cantidad ); //resta
                    $nuevo->cantidad_disponible = abs($cant);
                    $nuevo->save();
                    $nuevo = null;
                }
            }
            //termina
            $response = [
                'status' => true,
                'mensaje' => 'El producto ha sido entregado',
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
            ];
        }
        echo json_encode($response);
    }

    protected function actualizarStockProducto($productos_id, $stock)
    {
        $producto = Productos::find($productos_id);
        $producto->stock += $stock;
        $producto->save();
    }

    public function nuevoMovimiento($recetas_id)
    {
        $nuevMovimiento = new Movimientos();
        $nuevMovimiento->tipo_movimiento = 'S';
        $nuevMovimiento->recetas_id = $recetas_id;
        $nuevMovimiento->fecha = date('Y-m-d');
        $nuevMovimiento->save();

        return $nuevMovimiento;
    }

    public function regresionLineal($params)
    {
        $this->cors->corsJson();
        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $temporalidad = $params['temporalidad'];
        $entregados = 4;

        if(intval($temporalidad) == 1){ //Por día

            $dataCita = Citas::where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)
                                ->where('estado_cita_id',$entregados)->get();                          
        }else
        if(intval($temporalidad) == 2){ //Por mes
            $mesInicio = intval(explode('-', $params['inicio'])[1]);
            $mesFin = intval(explode('-', $params['fin'])[1]);

            $dataCita = Citas::whereMonth('fecha', '>=', $mesInicio)->whereMonth('fecha', '<=', $mesFin)
                                ->where('estado_cita_id',$entregados)->get();
        }else{  //Por Año
            $anioInicio = intval(explode('-', $params['inicio'])[0]);
            $anioFin = intval(explode('-', $params['fin'])[0]);

            $dataCita = Citas::whereYear('fecha', '>=', $anioInicio)->whereYear('fecha', '<=', $anioFin)
                                ->where('estado_cita_id',$entregados)->get();
        }

        $new = [];
        foreach($dataCita as $dc){
            $fechaCita = $dc->fecha;
            foreach($dc->recetas as $r){
                $fechaR = $r->fecha;
                $dr = $r->detalle_receta;
            }
            foreach($dr as $item){
                $aux =[
                    'receta_id' => $item->recetas_id,
                    'dataTotal' => $item->cantidad,
                    'fecha_cita' => $fechaCita,
                    'fecha_receta' => $fechaR,
                ];
                $new[] = (object)$aux;
                $receta_id[] = $item->recetas_id;
            }            
        }


        //echo json_encode($new); die();

        $norepetidosRecetasProductos = array_values(array_unique($receta_id));
        $nuevoarrayRecetaProducto = [];  $contadorReceta = 0;

        for ($j = 0; $j < count($norepetidosRecetasProductos); $j++) {
            foreach ($new as $prorec) {
                if ($prorec->receta_id === $norepetidosRecetasProductos[$j]) {
                    $contadorReceta += $prorec->dataTotal;
                    $ferchaCita = $prorec->fecha_cita;
                    $ferchaReceta = $prorec->fecha_receta;

                }
            }

            $auxReceta = [
                'receta_id' => $norepetidosRecetasProductos[$j],
                'cantidad_producto_recetas' => $contadorReceta,
                'fechaCita' => $ferchaCita,
                'fechaReceta' => $ferchaReceta
            ];
            $contadorReceta = 0;
            $nuevoarrayRecetaProducto[] = (object) $auxReceta;
            $auxReceta = [];
        }

        //echo json_encode($nuevoarrayRecetaProducto); die();


        $fechaCita = []; $fechaReceta = []; $data = []; $totalEntregadoProducto = 0;
        $xProm = 0; $yProm = 0; $n = count($dataCita); $i = 1; $dataTotal = [];
        $sumXY = 0; $sumX2 = 0; $margen = 0.5;

        foreach($nuevoarrayRecetaProducto as $nar){
            $totalEntregadoProducto += $nar->cantidad_producto_recetas;
            $data[] =  $nar->cantidad_producto_recetas;
            $fechaCita[] = $nar->fechaCita;
            $fechaReceta[] = $nar->fechaReceta;
            $xProm += $i;

            $yProm += $nar->cantidad_producto_recetas;
            $xy = $i * $nar->cantidad_producto_recetas;
            $x2 = pow($i, 2);

            $sumXY += $xy;
            $sumX2 += $x2;
            $i++;
        }

        $xProm = $xProm / $n;   $yProm = $yProm / $n;
        
        $b = (($sumXY) - ($n * $xProm * $yProm)) / (($sumX2) - ($n * $xProm * $xProm));
        $a = $yProm - ($b * $xProm);

        //Evaluar mínimo y máximo 
        $fx1 = $a + $b * 1;
        $fxn = $a + $b * count($data);
        $proyeccion = $a + $b * (count($data) + 1);

        //echo json_encode($proyeccion); die();

        
        $dataGeneral = [
            'data' => [
                'datos' => ($data),    //Dispersión,
                'fechaCita' => ($fechaCita),
                'fechaRecetaEntregado' => ($fechaReceta),
                'puntos' => [
                    'inicio' => [
                        'x' => 1, 'y' => $fx1
                    ],
                    'fin' => [
                        'x' => count($dataCita) , 'y' =>  $fxn
                    ],
                    'proyeccion' => [
                        'x' => count($data) + 1,
                        'y' => round(($proyeccion),6),
                        'total_producto_entregado' => $totalEntregadoProducto
                    ]
                ]
            ],
            'constantes' => [
                'a' => $a,
                'b' => $b
            ],
            'promedios' => [
                'x' => $xProm,
                'y' => $yProm 
            ],
            'ecuacion' => [
                'f(x)' => $a.' + ('.$b.')(x)',
                'signo' => ($b > 0) ? '+': '-',
                'margen' => [
                    'x' => [
                        'minimo' => 1 - $margen,
                        'maximo' => count($dataCita) + $margen
                    ],
                    'y' => [
                        'minimo' => 0
                    ]
                ]
            ]
        ];
        echo json_encode($dataGeneral);
    }

    public function pendienteContar()
    {
        $this->cors->corsJson();
        $dataCita = Citas::where('estado', 'A')->where('estado_cita_id',1)->get();
        $response = [];

        if ($dataCita) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Citas Pendiente',
                'cantidad' => $dataCita->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Citas Pendiente',
                'cantidad' => 0,
            ];
        }
        echo json_encode($response);

    }

    public function atendidaContar()
    {
        $this->cors->corsJson();
        $dataCita = Citas::where('estado', 'A')->where('estado_cita_id',2)->get();
        $response = [];

        if ($dataCita) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Citas Atendidas',
                'cantidad' => $dataCita->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Citas Atendidas',
                'cantidad' => 0,
            ];
        }
        echo json_encode($response);

    }

    public function listarCitasAtendidaEntregadayNoEntregada()//
    {
        $this->cors->corsJson();
        $citaAtendido = 2;
        $citaEntregado = 4;
        $dataCitas = Citas::where('estado', 'A')->where('estado_cita_id',$citaEntregado)->orWhere('estado_cita_id',$citaAtendido)->orderBy('id','desc')->get();
        $data = []; $i = 1;  $entr = '';

        foreach($dataCitas as $dc){
            $usuario = $dc->usuarios->personas;
            $doctor = $dc->doctores->personas;
            $horario = $dc->horario;
            $especialidad = $dc->especialidad;
            $paciente = $dc->pacientes->personas;
            $estadoCita = $dc->estado_cita;
            $dataFechaCita = $dc->horario->fecha;

            foreach($dc->recetas as $r){
                $entr = $r->entregado;
            }

            $No = 'No';  $Si = 'Si';
            if($entr == 'N'){
                $estadoEntr = '<span class="badge bg-danger" style="font-size: 1rem;">' . $No . '</span>';
            }else{
                $estadoEntr = '<span class="badge bg-primary" style="font-size: 1rem;">' . $Si . '</span>';
            }

            //substr para quitar los ceros de la derecha
            $horario = substr($horario->hora_atencion, 0, -3);
            $estado = $dc->estado_cita_id;

            if ($estado == 2) {//atendido
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $estadoCita->detalle . '</span>';
            }else if($estado == 4){//entregado 
                $estado = '<span class="badge bg-dark" style="font-size: 1rem;">' . $estadoCita->detalle . '</span>';
            }

            $other = $dc->estado_cita_id == 2 ? 4 : '';
            $disabledEntregado = $dc->estado_cita_id == 4 ? 'disabled' : ' ';

            $botones = '<div class="text-center">
                            <button ' . $disabledEntregado . ' class="btn btn-sm btn-outline-primary" onclick="entregaProducto(' . $dc->id . ',' . $other . ')">
                                <i class="fas fa-check"></i> 
                            </button> 
                            <button class="btn btn-sm btn-outline-dark" onclick="verProductoEntregados(' . $dc->id . ')">
                                <i class="fas fa-eye"></i> 
                            </button> 
                        </div>';

            $data[] = [
                0 => $i,
                1 => $usuario->nombre . ' ' . $usuario->apellido,
                2 => $doctor->nombre . ' ' . $doctor->apellido,
                3 => $especialidad->especialidad,
                4 => $paciente->nombre . ' ' . $paciente->apellido,
                5 => $dataFechaCita,
                6 => $horario,
                7 => $estadoEntr,
                8 => $estado,
                9 => $botones,
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

    //empieza kpi general
    public function indicadoresGlobales(){ //cargar de manera Global
        $this->cors->corsJson();
        $response = [];

        $dataSatisfacion = $this->satisfaccionPaciente();//citas con escala satifaccion
        $estadosCitas = $this->estadosCitas();// citas con estados_citas
        $cantidadVacunasCampaña = $this->cantidadVacunasCampaña();//campañas con aplicar vacunas
        $timePaciente = $this->timePacienteKPI();

        $response = [
            'status' => true,
            'mensaje' =>'existen datos',
            'data' => [
                'satifaccionPaciente' => $dataSatisfacion,
                'estadosCitas' => $estadosCitas,
                'campanias' => $cantidadVacunasCampaña,
                'timePaciente' => $timePaciente
            ],     
        ];

        echo json_encode($response);   
    }

    public function satisfaccionPaciente(){

        $sinCalificar = 1;  $limite = 3;  $entregado = 4;  $response = [];

        $totalvaloracionesobtenidas = Citas::where('estado','A')->where('estado_cita_id','=',$entregado)->where('escala_satisfacion_id','<>',$sinCalificar)->count();

        if($totalvaloracionesobtenidas){
            //positivo
            $sumaValoracionPositivo = Citas::join('escala_satisfacion','escala_satisfacion_id','=','escala_satisfacion.id')
                                            ->where('estado_cita_id','=',$entregado)
                                            ->where('escala_satisfacion.valor','>=',$limite)->get()
                                            ->sum('escala_satisfacion.valor'); //Sumatoria de valoaciones positivas
                                
            $csat_promedioPositivo = round(($sumaValoracionPositivo / $totalvaloracionesobtenidas), 2); //formulaPositiva
            
            $cantidadValoracionPositiva = Citas::where('escala_satisfacion_id', '>', $limite)->where('estado_cita_id','=',$entregado)->count();
            
            $csat_porcentajePositivo = round((($cantidadValoracionPositiva / $totalvaloracionesobtenidas) * 100), 2); 

            //negativo
            $sumaValoracionNegativa = Citas::join('escala_satisfacion','escala_satisfacion_id','=','escala_satisfacion.id')
                                            ->where('estado_cita_id','=',$entregado)
                                            ->where('escala_satisfacion.valor','<',$limite)->get()
                                            ->sum('escala_satisfacion.valor'); //Sumatoria de valoaciones negativas
            
            $csat_promedioNegativo = round(($sumaValoracionNegativa / $totalvaloracionesobtenidas), 2); //formulaNegativa

            $cantidadValoracionNegativa = Citas::where('escala_satisfacion_id', '<=', $limite)->where('escala_satisfacion_id','>',$sinCalificar)->where('estado_cita_id','=',$entregado)->count();

            $csat_porcentajeNegativo = round((($cantidadValoracionNegativa / $totalvaloracionesobtenidas) * 100), 2);

            $response = [    
                'totalValoraciones' => $totalvaloracionesobtenidas,
                'positivo' => [
                    'sumaValoracion' => $sumaValoracionPositivo,
                    'csat_promedio' => $csat_promedioPositivo, 
                    'csat_porcentaje' => $csat_porcentajePositivo,
                    'rango' => $cantidadValoracionPositiva
                ], 
                'negativo' => [
                    'sumaValoracion' => $sumaValoracionNegativa,
                    'csat_promedio' => $csat_promedioNegativo, 
                    'csat_porcentaje' => $csat_porcentajeNegativo,
                    'rango' => $cantidadValoracionNegativa
                ],
            ];
        }
        return $response;
    }

    public function estadosCitas(){
        $this->cors->corsJson();
        $estadoCitas = Estado_Cita::where('estado', 'A')->get(); 
       
        $labels = [];  $data = [];  $dataPorcentaje = [];  $response = [];  $suma = 0;

        foreach($estadoCitas as $item){
            $citas = $item->citas;
            $labels[] = $item->detalle;  
            $data[] = count($citas);
        }

        for($i=0; $i<count($data); $i++){
            $suma += $data[$i];
        }

        for($i=0; $i< count($data); $i++){
            $aux = ( (100 * $data[$i] ) / $suma);
            $dataPorcentaje[] = round($aux,2);    
        }

        $response = [
            'serie' => [
                'labels' => $labels,
                'count' => $data,
                'porcentaje'=> $dataPorcentaje,
                'colors' => [ '#FFE853', '#00d0eb', '#E10715', '#3FDC00' ],
            ]
        ];
        return  $response;
    }

    public function cantidadVacunasCampaña(){

        $this->cors->corsJson();   $limite = 5; 
        $dataCampania = Campania::where('estado','A')->orderBy('fecha','DESC')->take($limite)->get();
        $data = [];  $cantidad = 0; $aux = [];
 
        foreach ($dataCampania as $key) {
           $newArray =  $this->arrayCampania($key->id);

           if($newArray !== null){
               array_push($data,$newArray);
           }else{
                foreach($key->detalle_campania as $dc){
                    $cantidad = $dc->cantidad;
                }
                $aux = [
                    'nombre' =>  $key->nombre,
                    'total' => $cantidad,
                    'restante' => 0
                ];
               array_push($data,$aux);
           }
        }
        return $data;
    }

    private function timePacienteKPI(){
        $this->cors->corsJson(); $cancelado = 3;  $response = []; $limite = 10;

        $dataCita = Citas::join('horario','horario_id','=','horario.id')
            ->selectRaw('intervalo')
            ->selectRaw("MINUTE(TIMEDIFF(h_salida, date_add(hora_atencion, interval intervalo minute))) as diff_atencion")
            ->where('estado_cita_id','<>', $cancelado)->whereNotNull('h_entrada')
            ->orderBy('citas.fecha', 'ASC')->orderBy('hora_atencion', 'ASC')
            ->having('diff_atencion', '>','0')->having('diff_atencion', '<', $limite)->get();

        $data30Min = []; $xKey30 = [];  $yValues30 = []; $coVa30 = 0;  $gamma30 = 0;  $sigma30 = 0;   $promedio30Min = 0;
        $data60Min = []; $xKey60 = [];  $yValues60 = []; $coVa60 = 0;  $gamma60 = 0;  $sigma60 = 0;   $promedio60Min = 0;   

        if(isset($dataCita)){
            $groupedIntervalo = $dataCita->mapToGroups(function ($item) { return [$item['intervalo'] => $item['diff_atencion']]; });

            $data30Min = $groupedIntervalo->get('30');         $data60Min = collect($groupedIntervalo)->get('60'); 

            if( $data30Min != null ){
                $promedio30Min = collect($data30Min)->avg();//promedio de los 30 min                        
                $data30MinCountBy = collect($data30Min)->countBy(); // contador de los 30 min                
                $xKey30 = $data30MinCountBy->keys(); //saco la posicion                             
                $yValues30 = $data30MinCountBy->values(); //valor                             
                $gamma30 = $this->returnGamma( $data30Min, $promedio30Min );
                                
                $sigma30 = sqrt($gamma30);                                         
                $coVa30 = (($sigma30 / $promedio30Min ) * 100);
            } 
            
            if( $data60Min != null ){
                $promedio60Min = collect($data60Min)->avg();
                $data60MinCountBy = collect($data60Min)->countBy();
                $xKey60 = $data60MinCountBy->keys();
                $yValues60 = $data60MinCountBy->values();
                $gamma60 = $this->returnGamma( $data60Min, $promedio60Min );    
                $sigma60 = sqrt($gamma60);
                $coVa60 = (($sigma60 / $promedio60Min ) * 100);
            }

            $response = [
                'time30' => [
                    'x' => $xKey30,
                    'y' => $yValues30,
                    'media' => round( $promedio30Min, 2),
                    'desviacion' =>  round( $sigma30, 2),
                    'coeficiente_variacion' => round( $coVa30, 2),
                ],
                'time60' => [
                    'x' => $xKey60,
                    'y' => $yValues60,
                    'media' => round( $promedio60Min, 2),
                    'desviacion' => round( $sigma60, 2),
                    'coeficiente_variacion' => round( $coVa60 , 2)
                ],
            ];
        }
        return $response;
    }

    private function returnGamma($data, $media, $muestra = 0){//formula de varianza
        $gamma = 0;  $n = count($data);
        foreach($data as $x){
            $gamma = ( $gamma + ( pow( ($x - $media),2 ) / ( $n - $muestra ) ) );  //formula de poblacion
        }
        return $gamma;  //desviacion estandar
    }

    private function arrayCampania($campania_id){
  
        $dataAplicarVacuna = Aplicar_Vacuna::where('estado','A')->where('campania_id',$campania_id)
                                            ->orderBy('total_restante','ASC')->get()->first();

        $aux = null;

        if(isset($dataAplicarVacuna) && $dataAplicarVacuna !== null ){
            $aux = [
                'nombre' => $dataAplicarVacuna->campania->nombre,
                'total' => $dataAplicarVacuna->total_vacuna,
                'restante' => $dataAplicarVacuna->total_restante
            ];
        }
        return  $aux;
    }

    //termina kpi general


    //parametrizado
    public function indicadoresGlobalesDate($params){
        $this->cors->corsJson();
        $inicio = $params['inicio'];  $fin = $params['fin'];
        
        if($inicio  && $fin){
            $dataSatisfacion =  $this->formulaSatisfaccionPacienteDate($inicio,$fin);
            $dataEstadosCitas = $this->estadoCitasDate($inicio,$fin);
            $cantidadVacunasCampaña = $this->cantidadVacunasCampañaDate($inicio,$fin);
            $timePacienteKPI = $this->timePacienteKPIDate($inicio,$fin);

            $response = [
                'status' => true,
                'data' => [
                    'satifaccionPaciente' => $dataSatisfacion,
                    'estadosCitas' => $dataEstadosCitas,
                    'campanias' => $cantidadVacunasCampaña,
                    'timePaciente' => $timePacienteKPI
                ]
            ];
        }
        echo json_encode($response);
    }
          
    public function formulaSatisfaccionPacienteDate($inicio,$fin){

        $sinCalificar = 1; $limite = 3;  $entregado = 4;  $response = [];

        $sumaValoracionPositivo = 0;  $csat_promedioPositivo = 00.0;  $csat_porcentajePositivo = 00.0;  $cantidadValoracionPositiva = 0;

        $sumaValoracionNegativa = 0;  $csat_promedioNegativo = 00.0;  $csat_porcentajeNegativo = 00.0;  $cantidadValoracionNegativa = 0;

        $totalvaloracionesobtenidas = Citas::where('estado','A')->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)
                                                ->where('estado_cita_id', $entregado)->where('escala_satisfacion_id','<>',$sinCalificar)
                                                ->count();

            if( isset($totalvaloracionesobtenidas) && $totalvaloracionesobtenidas ){    
                //positivo
                $sumaValoracionPositivo = Citas::join('escala_satisfacion','escala_satisfacion_id','=','escala_satisfacion.id')
                                                ->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)
                                                ->where('estado_cita_id','=',$entregado)
                                                ->where('escala_satisfacion.valor','>=',$limite)->get()
                                                ->sum('escala_satisfacion.valor'); //Sumatoria de valoraciones positivas

                $csat_promedioPositivo = round(($sumaValoracionPositivo / $totalvaloracionesobtenidas), 2); //formulaPositiva

                $cantidadValoracionPositiva = Citas::where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)
                                                    ->where('escala_satisfacion_id', '>', $limite)
                                                    ->where('estado_cita_id','=',$entregado)->count();

                $csat_porcentajePositivo = round((($cantidadValoracionPositiva / $totalvaloracionesobtenidas) * 100), 2);

                 //negativo
                $sumaValoracionNegativa = Citas::join('escala_satisfacion','escala_satisfacion_id','=','escala_satisfacion.id')
                                                ->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)
                                                ->where('estado_cita_id','=',$entregado)
                                                ->where('escala_satisfacion.valor','<',$limite)->get()
                                                ->sum('escala_satisfacion.valor'); //Sumatoria de valoraciones negativas

                $csat_promedioNegativo = round(($sumaValoracionNegativa / $totalvaloracionesobtenidas), 2); //formulaNegativa

                $cantidadValoracionNegativa = Citas::where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)
                                                    ->where('escala_satisfacion_id', '<=', $limite)
                                                    ->where('escala_satisfacion_id','>',$sinCalificar)
                                                    ->where('estado_cita_id','=',$entregado)->count();

                $csat_porcentajeNegativo = round((($cantidadValoracionNegativa / $totalvaloracionesobtenidas) * 100), 2);

                $response = [
                    'totalValoraciones' => $totalvaloracionesobtenidas,
                    'positivo' => [
                        'sumaValoracion' => $sumaValoracionPositivo,
                        'csat_promedio' => $csat_promedioPositivo, 
                        'csat_porcentaje' => $csat_porcentajePositivo,
                        'rango' => $cantidadValoracionPositiva
                    ],
                    'negativo' => [
                        'sumaValoracion' => $sumaValoracionNegativa,
                        'csat_promedio' => $csat_promedioNegativo, 
                        'csat_porcentaje' => $csat_porcentajeNegativo,
                        'rango' => $cantidadValoracionNegativa
                    ], 
                ];
            }else{
                $response = [
                    'totalValoraciones' => $totalvaloracionesobtenidas,
                    'positivo' => [
                        'sumaValoracion' => $sumaValoracionPositivo,
                        'csat_promedio' => $csat_promedioPositivo, 
                        'csat_porcentaje' => $csat_porcentajePositivo,
                        'rango' => $cantidadValoracionPositiva
                    ],
                    'negativo' => [
                        'sumaValoracion' => $sumaValoracionNegativa,
                        'csat_promedio' => $csat_promedioNegativo, 
                        'csat_porcentaje' => $csat_porcentajeNegativo,
                        'rango' => $cantidadValoracionNegativa
                    ],
                ];
            }
            return $response; 
    }

    public function estadoCitasDate($inicio,$fin){
        $this->cors->corsJson();

        $leftJoinCitas = Citas::leftJoin('estado_cita', 'estado_cita.id', '=', 'estado_cita_id')
                    ->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)
                    ->selectRaw('estado_cita_id, detalle, count(estado_cita.id) as cantidad')
                    ->groupBy('estado_cita_id')
                    ->get();

        $labels = [];  $data = [];  $dataPorcentaje = [];  $response = [];
        
        $estadoCitas = Estado_Cita::where('estado', 'A')->get(); 

        foreach($estadoCitas as $item){
            $labels[] = $item->detalle;
        }

        if (isset($leftJoinCitas) &&  $leftJoinCitas) {
            $suma = 0;
            
            for ($i=0; $i < count($labels) ; $i++) { 
                array_push($data, $this->retornarCantidad($leftJoinCitas, $labels[$i]));
            }
    
            for($i=0; $i<count($data); $i++){
                $suma += $data[$i];
            }

            if($suma !== 0){
                for($i=0; $i< count($data); $i++){
                    $aux = ( (100 * $data[$i] ) / $suma);
                    $dataPorcentaje[] = round($aux,2);    
                }
            }else{
                for($i=0; $i< count($labels); $i++){
                    $dataPorcentaje[] = round(00.00,2);    
                }
            }

            $response = [
                'serie' => [
                    'labels' => $labels,
                    'count' => $data,
                    'porcentaje'=> $dataPorcentaje,
                    'colors' => [ '#FFE853', '#00d0eb', '#E10715', '#3FDC00' ],
                ]
            ];
        }else{
            $response = [
                'serie' => [
                    'labels' => $labels,
                    'count' => $data,
                    'porcentaje'=> $dataPorcentaje,
                    'colors' => [ '#FFE853', '#00d0eb', '#E10715', '#3FDC00' ],
                ]
            ];
        }
        return $response;
    }

    private function retornarCantidad($data, $valor) {
        foreach ($data as $item) {
            if($item->detalle === $valor){
                return $item->cantidad;
            }
        }
        return 0;
    }

    public function cantidadVacunasCampañaDate($inicio,$fin){

        $this->cors->corsJson();   $limite = 5;
        $dataCampania = Campania::where('estado','A')->whereBetween('fecha', [$inicio,$fin])->take($limite)->orderBy('fecha','DESC')->get();

        $data = [];

        foreach ($dataCampania as $key) {
           $newArray =  $this->arrayCampaniaDate($key->id,$inicio,$fin);

           if($newArray !== null){
               array_push($data,$newArray);
           }else{
                foreach($key->detalle_campania as $dc){
                    $cantidad = $dc->cantidad;
                }
                $aux = [
                    'nombre' =>  $key->nombre,
                    'total' => $cantidad,
                    'restante' => 0
                ];
                array_push($data,$aux);
            }
        }
        return $data;
    }

    private function arrayCampaniaDate($campania_id,$inicio,$fin){

        $dataAplicarVacuna = Aplicar_Vacuna::where('estado','A')->where('campania_id',$campania_id)
                                            ->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)
                                            ->orderBy('total_restante','ASC')->get()->first();

        $aux = null;

        if(isset($dataAplicarVacuna) && $dataAplicarVacuna !== null ){
            $aux = [
                'nombre' => $dataAplicarVacuna->campania->nombre,
                'total' => $dataAplicarVacuna->total_vacuna,
                'restante' => $dataAplicarVacuna->total_restante
            ];
        }
        return  $aux;
    }

    public function timePacienteKPIDate($inicio,$fin){
        $this->cors->corsJson(); $cancelado = 3;  $response = [];

        $dataCita = Citas::join('horario','horario_id','=','horario.id')
            ->selectRaw('intervalo')
            ->selectRaw("MINUTE(TIMEDIFF(h_salida, date_add(hora_atencion, interval intervalo minute))) as diff_atencion")
            ->whereBetween('citas.fecha', [$inicio, $fin])
            ->where('estado_cita_id','<>', $cancelado)->whereNotNull('h_entrada')
            ->orderBy('citas.fecha', 'ASC')->orderBy('hora_atencion', 'ASC')
            ->having('diff_atencion', '>','0')->get();

            $data30Min = []; $xKey30 = [];  $yValues30 = []; $coVa30 = 0;  $gamma30 = 0;  $sigma30 = 0;   $promedio30Min = 0;
            $data60Min = []; $xKey60 = [];  $yValues60 = []; $coVa60 = 0;  $gamma60 = 0;  $sigma60 = 0;   $promedio60Min = 0;   
    
            if(isset($dataCita)){
                $groupedIntervalo = $dataCita->mapToGroups(function ($item) { return [$item['intervalo'] => $item['diff_atencion']]; });
    
                $data30Min = $groupedIntervalo->get('30');         $data60Min = collect($groupedIntervalo)->get('60'); 
    
                if( $data30Min != null ){
                    $promedio30Min = collect($data30Min)->avg();                        
                    $data30MinCountBy = collect($data30Min)->countBy();                 
                    $xKey30 = $data30MinCountBy->keys();                                
                    $yValues30 = $data30MinCountBy->values();                           
                    $gamma30 = $this->returnGamma( $data30Min, $promedio30Min , 1 );
                                    
                    $sigma30 = sqrt($gamma30);                                         
                    $coVa30 = (($sigma30 / $promedio30Min ) * 100);
                } 
                
                if( $data60Min != null ){
    
                    $promedio60Min = collect($data60Min)->avg();
                    $data60MinCountBy = collect($data60Min)->countBy();
                    $xKey60 = $data60MinCountBy->keys();
                    $yValues60 = $data60MinCountBy->values();
                    $gamma60 = $this->returnGamma( $data60Min, $promedio60Min, 1 );    
                    $sigma60 = sqrt($gamma60);
                    $coVa60 = (($sigma60 / $promedio60Min ) * 100);
                }
    
                $response = [
                    'time30' => [
                        'x' => $xKey30,
                        'y' => $yValues30,
                        'media' => round( $promedio30Min, 2),
                        'desviacion' =>  round( $sigma30, 2),
                        'coeficiente_variacion' => round( $coVa30, 2),
                    ],
                    'time60' => [
                        'x' => $xKey60,
                        'y' => $yValues60,
                        'media' => round( $promedio60Min, 2),
                        'desviacion' => round( $sigma60, 2),
                        'coeficiente_variacion' => round( $coVa60 , 2)
                    ],
                ];
            }
            return $response;
    }

   
}