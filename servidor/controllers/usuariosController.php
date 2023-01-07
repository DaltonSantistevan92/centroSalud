<?php
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'core/conexion.php';
require_once 'app/helper.php';
require_once 'models/usuariosModel.php';
require_once 'models/personasModel.php';
require_once 'controllers/personasController.php';
require_once 'controllers/doctoresController.php';
require_once 'controllers/enfermeroController.php';


class UsuariosController
{
    private $cors;
    private $personaCntr;
    private $doctorCntr;
    private $enfermeroCntr;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->personaCntr = new PersonasController();
        $this->doctorCntr = new DoctoresController();
        $this->enfermeroCntr = new EnfermeroController();

    }

    public function listarId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $dataUsuario = Usuarios::find($id);
        $response = [];

        if ($dataUsuario) {
            $dataUsuario->roles;
            $dataUsuario->personas->sexo;

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'usuario' => $dataUsuario,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'usuario' => null,
            ];
        }
        echo json_encode($response);
    }

    public function login(Request $request) 
    {
        $this->cors->corsJson();
        $data = $request->input('login');
        $usuario = $data->usuario;
        $clave = $data->clave;
        $encriptarClave = hash('sha256', $clave);
        $response = [];

        if ((!isset($usuario) || $usuario == "") || (!isset($clave) || $clave == "")) {
            $response = [
                'status' => false,
                'mensaje' => 'Falta datos',
            ];
        } else {
            $persona = Personas::where('cedula', $usuario)->get()->first();
            $usuario = Usuarios::where('usuario', $usuario)->orWhere('correo', $usuario)->get()->first();

            
            if ($usuario || $persona) {
                $usuario = $usuario;
                if($persona){
                    $usuario = $persona->usuarios[0];
                }

                $doctor = $usuario->personas->doctores;
                $doc_id = []; $enfermero_id = [];

                $enfermero = $usuario->personas->enfermero;

                foreach ($doctor as $doc) {
                    $doc_id = intval($doc->id);
                }

                foreach ($enfermero as $enf) {
                    $enfermero_id = intval($enf->id);
                }


                if ($this->validarCredenciales($encriptarClave, $usuario->clave)) {
                    $rol_cargo = $usuario->roles->cargo;
                    $persona_id = $usuario->personas_id;

                    $per = Personas::find($persona_id);
                    $usuario['persona'] = $per;
                    $nombre = $per->nombre . ' ' . $per->apellido;

                    $response = [
                        'status' => true,
                        'mensaje' => 'Bienvenido al Sistema',
                        'rol' => $rol_cargo,
                        'persona' => $nombre,
                        'usuario' => $usuario,
                        'doctor' => $doc_id,
                        'enfermero' => $enfermero_id
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La contraseña es incorrecta',
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'El usuario es incorrecto',
                ];
            }
        }
        echo json_encode($response);
    }

    public function loginant(Request $request) 
    {
        $this->cors->corsJson();
        $data = $request->input('login');
        $usuario = $data->usuario;
        $clave = $data->clave;
        $encriptarClave = hash('sha256', $clave);
        $response = [];

        if ((!isset($usuario) || $usuario == "") || (!isset($clave) || $clave == "")) {
            $response = [
                'status' => false,
                'mensaje' => 'Falta datos',
            ];
        } else {
            $usuario = Usuarios::where('usuario', $usuario)->get()->first();

            if ($usuario) {
                $doctor = $usuario->personas->doctores;
                $doc_id = []; $enfermero_id = [];

                $enfermero = $usuario->personas->enfermero;

                foreach ($doctor as $doc) {
                    $doc_id = intval($doc->id);
                }

                foreach ($enfermero as $enf) {
                    $enfermero_id = intval($enf->id);
                }


                if ($this->validarCredenciales($encriptarClave, $usuario->clave)) {
                    $rol_cargo = $usuario->roles->cargo;
                    $persona_id = $usuario->personas_id;

                    $per = Personas::find($persona_id);
                    $usuario['persona'] = $per;
                    $nombre = $per->nombre . ' ' . $per->apellido;

                    $response = [
                        'status' => true,
                        'mensaje' => 'Bienvenido al Sistema',
                        'rol' => $rol_cargo,
                        'persona' => $nombre,
                        'usuario' => $usuario,
                        'doctor' => $doc_id,
                        'enfermero' => $enfermero_id
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La contraseña es incorrecta',
                    ];
                }
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'El usuario es incorrecto',
                ];
            }
        }
        echo json_encode($response);
    }

    private function validarCredenciales($credencial1, $credencial2)
    {
        if ($credencial1 == $credencial2) {
            return true;
        } else {
            return false;
        }
    }

    public function guardarUsuario(Request $request)
    {
        $this->cors->corsJson();
        $usuarioRequest = $request->input('usuario');
        $doctorRequest = $request->input('doctor');
        $enfermeroRequest = $request->input('enfermero');


        $response = [];

        if (!isset($usuarioRequest) || $usuarioRequest == null) {
            $response = [
                'status' => false,
                'mensaje' => "No hay datos para procesar",
                'usuario' => null,
            ];
        } else {
            $responsePersona = $this->personaCntr->guardarPersona($request);

            $id_persona = $responsePersona['persona']->id; //recuperar el id de persona

            $clave = $usuarioRequest->clave;
            $encriptar = hash('sha256', $clave);

            $nuevoUsuario = new Usuarios();
            $nuevoUsuario->roles_id = intval($usuarioRequest->roles_id);
            $nuevoUsuario->personas_id = intval($id_persona);
            $nuevoUsuario->usuario = ucfirst($usuarioRequest->usuario);
            $nuevoUsuario->correo = $usuarioRequest->correo;
            $nuevoUsuario->clave = $encriptar;
            $nuevoUsuario->conf_clave = $encriptar;
            $nuevoUsuario->foto = $usuarioRequest->foto;
            $nuevoUsuario->estado = 'A';

            $existeUsuario = Usuarios::where('personas_id', $id_persona)->get()->first();

            if ($existeUsuario) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El usuario ya existe',
                    'usuario' => null,
                ];
            } else {
                if ($nuevoUsuario->save()) {
                    if ($usuarioRequest->roles_id == 3) { //guardar en la tabla doctor

                        $responseDoctor = $this->doctorCntr->guardardoctor($doctorRequest, $id_persona);

                        if ($responseDoctor == false) {
                            $response = [
                                'status' => false,
                                'mensaje' => 'El Doctor ya se encuentra registrado',
                                'usuario' => $responseDoctor,
                            ];
                        } else {
                            $response = [
                                'status' => true,
                                'mensaje' => 'El doctor se guardo correctamente',
                                'doctor' => $responseDoctor,
                            ];
                        }
                    }else if($usuarioRequest->roles_id == 5){ //guarda en la tabla enfermero

                        $responseEnfermero = $this->enfermeroCntr->guardarEnfermero($enfermeroRequest, $id_persona);

                        if ($responseEnfermero == false) {
                            $response = [
                                'status' => false,
                                'mensaje' => 'El Enfermero ya se encuentra registrado',
                                'enfermero' => $responseEnfermero,
                            ];
                        } else {
                            $response = [
                                'status' => true,
                                'mensaje' => 'El Enfermero se guardo correctamente',
                                'enfermero' => $responseEnfermero,
                            ];
                        }
                    }
                    $response = [
                        'status' => true,
                        'mensaje' => 'El usuario se guardo correctamente',
                        'usuario' => $nuevoUsuario,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El usuario no se pudo guardar',
                        'usuario' => null,
                    ];
                }
            }
        }
        echo json_encode($response);
    }

    public function subirFoto($file)
    {
        $this->cors->corsJson();
        $img = $file['fichero'];
        $path = 'resources/usuarios/';
        $response = Helper::save_file($img, $path);
        echo json_encode($response);
    }

    public function cardUsuario()
    {
        $this->cors->corsJson();
        $rolDoctor = 3;  $rolEnfermero = 5;
        $usuario = Usuarios::where('estado', 'A')->where('roles_id', '<>', $rolDoctor)
                                ->where('roles_id', '<>', $rolEnfermero)->get();
        $response = [];

        if (count($usuario) > 0) {
            foreach ($usuario as $us) {
                $aux = [
                    'usuario' => $us,
                    'usuario_id' => $us->id,
                    'persona_id' => $us->personas->id,
                    'rol_id' => $us->roles->id,
                    'sexo_id' => $us->personas->sexo->id,
                ];
                $response[] = (object) $aux;
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay Usuarios Disponibles',
            ];
        }
        echo json_encode($response);
    }

    public function cardDoctor()
    {
        $this->cors->corsJson();
        $rolAdministrador = 1;   $rolRecepcionista = 2; $rolJefeDeFarmacia = 4;  $rolEnfermero = 5;
        $usuarioDoctor = Usuarios::where('estado', 'A')->where('roles_id', '<>', $rolAdministrador)
                                ->where('roles_id', '<>', $rolRecepcionista)
                                ->where('roles_id', '<>', $rolJefeDeFarmacia)
                                ->where('roles_id', '<>', $rolEnfermero)->get();
        $response = [];

        if (count($usuarioDoctor) > 0) {
            foreach ($usuarioDoctor as $us) {
                $aux = [
                    'usuario' => $us,
                    'usuario_id' => $us->id,
                    'persona_id' => $us->personas->id,
                    'rol_id' => $us->roles->id,
                    'sexo_id' => $us->personas->sexo->id,
                ];
                $response[] = (object) $aux;
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay Doctores Disponibles',
            ];
        }
        echo json_encode($response);
    }

    public function cardEnfermero()
    {
        $this->cors->corsJson();
        $rolAdministrador = 1;   $rolRecepcionista = 2;  $rolDoctor = 3; $rolJefeDeFarmacia = 4;  
        $usuarioDoctor = Usuarios::where('estado', 'A')->where('roles_id', '<>', $rolAdministrador)
                                ->where('roles_id', '<>', $rolRecepcionista)
                                ->where('roles_id', '<>', $rolDoctor)
                                ->where('roles_id', '<>', $rolJefeDeFarmacia)->get();
        $response = [];

        if (count($usuarioDoctor) > 0) {
            foreach ($usuarioDoctor as $us) {
                $aux = [
                    'usuario' => $us,
                    'usuario_id' => $us->id,
                    'persona_id' => $us->personas->id,
                    'rol_id' => $us->roles->id,
                    'sexo_id' => $us->personas->sexo->id,
                ];
                $response[] = (object) $aux;
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay Doctores Disponibles',
            ];
        }
        echo json_encode($response);
    }

    public function eliminarUsuario(Request $request)
    {
        $this->cors->corsJson();
        $usuarioRequest = $request->input('usuario');
        $id = $usuarioRequest->id;
        $dataUsuario = Usuarios::find($id);

        if ($usuarioRequest) {
            if ($dataUsuario) {
                $dataUsuario->estado = 'I';
                $dataUsuario->save();

                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado el usuario",
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => "No se puede eliminar el usuario",
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
            ];
        }
        echo json_encode($response);

    }

    public function editarUsuario(Request $request)
    {
        $this->cors->corsJson();
        $usuarioRequest = $request->input('usuario');
        $id = intval($usuarioRequest->id);

        $persona_id = intval($usuarioRequest->personas_id); 
        $roles_id = intval($usuarioRequest->roles_id); 
        $sexo_id = intval($usuarioRequest->sexo_id);
        
        $dataUsuario = Usuarios::find($id); 
        $response = [];

        if($usuarioRequest){
            if($dataUsuario){
                $dataUsuario->roles_id = $roles_id; 
                $dataUsuario->personas_id = $persona_id; 
                $dataUsuario->usuario = $usuarioRequest->usuario; 
                $dataUsuario->correo = $usuarioRequest->correo;

                $dataPersona = Personas::find($dataUsuario->personas_id);
                $dataPersona->nombre = ucfirst($usuarioRequest->nombre);
                $dataPersona->apellido = ucfirst($usuarioRequest->apellido);
                $dataPersona->num_celular = $usuarioRequest->num_celular;
                $dataPersona->direccion = $usuarioRequest->direccion;
                $dataPersona->sexo_id = $sexo_id;
                $dataPersona->save();
                $dataUsuario->save();
                
                $response = [
                    'status' => true,
                    'mensaje' => 'El usuario se ha actualizado correctamente',
                    'usuario' => $dataUsuario,
                ];
            }else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el usuario',
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
        $datausuario = Usuarios::where('estado', 'A')->get();
        $response = [];

        if ($datausuario) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Usuarios',
                'cantidad' => $datausuario->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Usuario',
                'cantidad' => 0,
            ];
        }
        echo json_encode($response);

    }

}
