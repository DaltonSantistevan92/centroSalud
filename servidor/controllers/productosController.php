<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/categoriasModel.php';
require_once 'models/productosModel.php';
require_once 'models/codigosModel.php';
require_once 'models/movimientosModel.php';
require_once 'controllers/inventarioController.php';



class ProductosController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listarxIdProductos($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $producto = Productos::find($id);
        $response = [];

        if($producto){
            $producto->categorias;
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'producto' => $producto,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'producto' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarProductos()
    {
        $this->cors->corsJson();
        $producto = Productos::where('estado', 'A')->get();
        $response = [];

        if ($producto) {
            foreach ($producto as $produ) {
                $produ->categorias;
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'producto' => $producto,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'producto' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarParaReceta()
    {
        $this->cors->corsJson();
        $producto = Productos::where('estado', 'A')->where('stock', '>=', 1)->get();
        $response = [];

        if ($producto) {
            foreach ($producto as $produ) {
                $produ->categorias;
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'producto' => $producto,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'producto' => null,
            ];
        }
        echo json_encode($response);
    }

    public function mostrarCodigo($params)
    {
        $this->cors->corsJson();
        $tipo = $params['tipo'];
        $dataCodigo = Codigos::where('tipo', $tipo)->orderBy('id', 'DESC')->first();
        $response = [];

        if ($dataCodigo == null) {
            $response = [
                'status' => true,
                'tipo' => $tipo,
                'mensaje' => 'Primera codigo',
                'codigo' => 'P0001',
            ];
        } else {
            $numero = substr($dataCodigo->codigo,1);
            $siguiente = 'P000' . ($numero += 1);
            $response = [
                'status' => true,
                'tipo' => $tipo,
                'mensaje' => 'Existen datos, aumentando codigo',
                'codigo' => $siguiente,
            ];
        }
        echo json_encode($response);
    }

    public function guardarCodigo(Request $request)
    {
        $codigoRequest = $request->input('codigo');
        $codigo = $codigoRequest->codigo;
        $tipo = $codigoRequest->tipo;
        $response = [];

        if ($codigoRequest == null) {
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos',
            ];
        } else {
            $nuevoCodigo = new Codigos();
            $nuevoCodigo->codigo = $codigo;
            $nuevoCodigo->tipo = $tipo;
            $nuevoCodigo->estado = 'A';
            $nuevoCodigo->save();

            $response = [
                'status' => true,
                'mensaje' => 'Guardando datos',
                'codigo' => $nuevoCodigo,
            ];
        }
        echo json_encode($response);
    }

    public function guardarProductos(Request $request)
    {
        $this->cors->corsJson();
        $productoRequest = $request->input('producto');
        $response = [];

        if ($productoRequest) {
            $categorias_id = intval($productoRequest->categorias_id);
            $codigo = $productoRequest->codigo;
            $nombre =  ucfirst($productoRequest->nombre);
            $descripcion = ucfirst($productoRequest->descripcion);
            $imagen = $productoRequest->imagen;
            $d_campania = $productoRequest->d_campania;

            $existecodigo = Productos::where('codigo', $codigo)->get()->first();

            if ($existecodigo) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El codigo ya existe',
                    'producto' => null,
                ];
            } else {
                $nuevoProducto = new Productos();
                $nuevoProducto->categorias_id = $categorias_id;
                $nuevoProducto->codigo = $codigo;
                $nuevoProducto->nombre = $nombre;
                $nuevoProducto->descripcion = $descripcion;
                $nuevoProducto->imagen = $imagen;
                $nuevoProducto->stock = 0;
                $nuevoProducto->fecha = date('Y-m-d');
                $nuevoProducto->d_campania = $d_campania;
                $nuevoProducto->estado = 'A';

                if ($nuevoProducto->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'El producto se ha guardado correctamente',
                        'producto' => $nuevoProducto,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El producto no se ha guardado',
                        'producto' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'producto' => null,
            ];
        }
        echo json_encode($response);
    }

    public function subirFotoProducto($file)
    {
        $this->cors->corsJson();
        $img = $file['fichero'];
        $path = 'resources/productos/';
        $response = Helper::save_file($img, $path);
        echo json_encode($response);

    }

    public function listarProductosDataTable()
    {
        $this->cors->corsJson();
        $productos = Productos::where('estado', 'A')->orderBy('codigo','Asc')->get();
        $data = [];  $i = 1;
        
        foreach ($productos as $p) {
            $url = BASE . 'resources/productos/' . $p->imagen;
            $disabled = $p->stock > 0 ? 'disabled' : ' ';
    
            $botones = '<div>
                            <button class="btn btn-primary btn-sm" onclick="editarProducto(' . $p->id . ')">
                                <i class="fa-solid fa-pen-to-square fa-lg"></i>
                            </button>
                            <button ' . $disabled . ' class="btn btn-dark btn-sm" onclick="eliminarProducto(' . $p->id . ')">
                                <i class="fa-solid fa-trash-can fa-lg"></i>
                            </button>
                        </div>';

            $colorStock = "";
            if ($p->stock < 5) {
                $colorStock = '<div class="text-center"><span class="badge bg-danger" style="font-size: 1.2rem;">' . $p->stock . '</span></div>';
            } else
            if ($p->stock >= 6 && $p->stock < 20) {
                $colorStock = '<div class="text-center"><span class="badge bg-warning" style="font-size: 1.2rem;">' . $p->stock . '</span></div>';
            } else {
                $colorStock = '<div class="text-center"><span class="badge bg-success" style="font-size: 1.2rem;">' . $p->stock . '</span></div>';
            }

            $data[] = [
                0 => $i,
                1 => '<div class="box-img-producto"><img  src=' . "$url" . '></div>',
                2 => $p->codigo,
                3 => $p->nombre,
                4 => $p->categorias->categoria,
                5 => $colorStock,
                6 => $p->fecha,
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

    public function eliminarProductos(Request $request)
    {
        $this->cors->corsJson();
        $productorequest = $request->input('producto');

        $producto_id = intval($productorequest->id);
        $producto = Productos::find($producto_id);
        $response = [];

        if ($productorequest) {
            if ($producto) {
                $producto->estado = 'I';
                $producto->save();

                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado producto",
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => "No se puede eliminar producto",
                ];
            }
        } else {
            $response = [
                'status' => false,
                'memsaje' => 'no hay datos para procesar',
                'producto' => null,
            ];
        }
        echo json_encode($response);
    }

    public function editarProducto(Request $request)
    {       
        $this->cors->corsJson();
        $productoRequest = $request->input('producto');
        $producto_id = intval($productoRequest->id);
        $categorias_id = intval($productoRequest->categorias_id);
        $productos = Productos::find($producto_id);
        $response = [];

        if ($productoRequest) {
            if ($productos) {
                $productos->categorias_id = $categorias_id;
                $productos->nombre = ucfirst($productoRequest->nombre);
                $productos->descripcion = ucfirst($productoRequest->descripcion);
                $productos->d_campania = $productoRequest->d_campania;

                $categoria = Categorias::find($productos->categorias_id);
                $categoria->save();
                $productos->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado el Producto',
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado el Producto',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
            ];
        }
        echo json_encode($response);
    }

    public function contar()
    {
        $this->cors->corsJson();
        $dataProducto = Productos::where('estado', 'A')->get();
        $response = [];

        if ($dataProducto) {
            $response = [
                'status' => true,
                'mensaje' => 'existe datos',
                'modelo' => 'Productos',
                'cantidad' => $dataProducto->count(),
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existe datos',
                'modelo' => 'Productos',
                'cantidad' => 0,
            ];
        }
        echo json_encode($response);
    }

    public function graficoStockProductos()
    {
        $this->cors->corsJson();
        $productos = Productos::where('estado', 'A')->get();
        $categorias = Categorias::where('estado', 'A')->get();

        $labels = [];  $data = []; $data2 = [];  $dataPorcentaje = [];  $response = [];  $suma = 0;

        if($categorias->count() > 0){
            
            foreach($categorias as $item){
                $nombreCategoria[] = $item->categoria;
                $producto = $item->productos;
                $data[] = count($producto);
                $aux = [];  $_cont = 0;

                foreach ($producto as $p) {
                    if ($item->id == $p->categorias->id) {
                        $_cont += $p->stock;
                    }
                }
                $data2[] = $_cont;
            }

            for ($i = 0; $i < count($data); $i++) {
                $suma += $data[$i];
            }

            for ($i = 0; $i < count($data); $i++) {
            $aux = ((100 * $data[$i]) / $suma);
            $dataPorcentaje[] = round($aux, 2);
        }

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'datos' => [
                    'labels' => $nombreCategoria,
                    'data' => $data2,
                    'porcentaje' => $dataPorcentaje,
                ],
            ];
            echo json_encode($response);
        }
    }

    public function buscarProducto($params){
        $this->cors->corsJson(); $response = []; 
        $texto = strtolower($params['texto']);

        $producto = Productos::where('nombre', 'like', '%' . $texto . '%')->get();
        
        if (count($producto) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Concidencias encontradas',
                'producto' => $producto
            ];
        }else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay registro',
                'producto' => null
            ];
        }
        echo json_encode($response);
        
    }

    public function listarParaCampania(){
        $this->cors->corsJson();
        $producto = Productos::where('d_campania',1)->get();
        $response = [];

        if ($producto) {
            foreach ($producto as $produ) {
                $produ->categorias;
            }

            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'producto' => $producto,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'producto' => null,
            ];
        }
        echo json_encode($response);
    }

    public function updateCampaniaProductos(Request $request){

        $this->cors->corsJson();
        $productoRequest = $request->input('producto');
        $campaniaRequest = $request->input('campania');
        $detallesRequest = $request->input('detalle');

        $productos_id = intval($productoRequest->productos_id);
        $campania_id  = intval($campaniaRequest->campania_id);
        
        $producto = Productos::find($productos_id);

        if($producto){
            $producto->stock += $productoRequest->stock; 

            if ($producto->save()) {
                
                $this->desocuparTodosEnfermeros($campania_id);

                //insertar en la tabla movimientos
                $nuevoMovimiento = $this->nuevoMovimiento($campania_id);

                //INSERTAR EN LA TABLA INVENTARIO
                $inventariocontroller = new InventarioController();
                $responseInventario = $inventariocontroller->guardarIngresoProducto($nuevoMovimiento->id, $detallesRequest, 'E');

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizo correctamente',
                    'producto' => $producto,
                    'movimientos' => $nuevoMovimiento,
                    'inventario' => $responseInventario
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'Error No se pudo actualizar',
                    'producto' => null,
                    'movimientos' => null,
                    'inventario' => null
                ];
            }    
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay data para procesar'
            ];
        }
        echo json_encode($response);

    }

    public function nuevoMovimiento($campania_id)
    {
        $nuevMovimiento = new Movimientos();
        $nuevMovimiento->tipo_movimiento = 'E';
        $nuevMovimiento->campania_id = $campania_id;
        $nuevMovimiento->fecha = date('Y-m-d');
        $nuevMovimiento->save();

        return $nuevMovimiento;
    }

    public function desocuparTodosEnfermeros($campania_id){
        $campania = Campania::find($campania_id);
        $enfermeros = [];

        if($campania){
            foreach($campania->campania_enfermero as $ce){
                $aux = [ 
                    'enfermero_id' => $ce->enfermero_id,
                    'campania_enfermero_id' => $ce->id
                ];
                $enfermeros[] = (object)$aux;
            }

            for ($i=0; $i < count($enfermeros); $i++) { 
                $enfermeros_id = $enfermeros[$i]->enfermero_id;
                $campania_enfermero_id = $enfermeros[$i]->campania_enfermero_id;


                $dataEnfermero = Enfermero::find($enfermeros_id);
                $dataEnfermero->ocupado = 'N';

                $dataCamEmfermero = Campania_Enfermero::find($campania_enfermero_id);
                $dataCamEmfermero->active = 'N';

                $dataEnfermero->save();
                $dataCamEmfermero->save();
            }

            $response = [
                'status' => true,
                'mensaje' => 'Se desocuparon todos los enfermeros de la campaña ' . $campania->nombre
            ];
        }else{
            $response = [];
        }
        return $response;
    }

}