<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/categoriasModel.php';


class CategoriasController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listarXid($params){
        $this->cors->corsJson(); 
        $id=intval($params['id']);
        $response = [];
        
        $categorias = Categorias::find($id);
        if ($categorias) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'categoria' => $categorias
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'categoria' => null
            ];
        }
        echo json_encode($response);
    }

    public function listarXidInventario($params)
    {
        $this->cors->corsJson(); 
        $id=intval($params['id']);
        $response = [];
        
        $categorias = Categorias::find($id);
        if ($categorias) {
            $categorias->productos;
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'categoria' => $categorias
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'categoria' => null
            ];
        }
        echo json_encode($response);

    }

    public function listarCategorias()
    {
        $this->cors->corsJson();
        $dataCategoria = Categorias::where('estado', 'A')->get();
        $response = [];

        if ($dataCategoria) {
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'categoria' => $dataCategoria,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'categoria' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardarCategoria(Request $request)
    {
        $this->cors->corsJson();
        $categoriaRequest = $request->input("categoria");
        $categoria = ucfirst($categoriaRequest->categoria);

        if ($categoriaRequest) {
            $existeCategoria = Categorias::where('categoria', $categoria)->get()->first();

            if ($existeCategoria) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La categoria ya existe',
                    'categoria' => null,
                ];
            } else {
                $nuevaCategoria = new Categorias();
                $nuevaCategoria->categoria = $categoria;
                $nuevaCategoria->estado = 'A';

                if ($nuevaCategoria->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'La categoria se ha guardado',
                        'categoria' => $nuevaCategoria,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La categoria no se puede guardar',
                        'categoria' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos para procesar',
                'categoria' => null,
            ];
        }
        echo json_encode($response);
    }

    public function eliminarCategoria(Request $request)
    {
        $this->cors->corsJson();
        $categoriaRequest = $request->input('categoria');
        $id = intval($categoriaRequest->id);
        $response = [];

        $dataCategoria = Categorias::find($id);
        if ($dataCategoria) {
            $dataCategoria->estado = 'I';
            $dataCategoria->save();

            $response = [
                'status' => true,
                'mensaje' => 'Categoria ha sido Eliminada',
                'categoria' => $dataCategoria
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede eliminar la categoria',
                'categoria' => null
            ];
        }
        echo json_encode($response);
    }

    public function editarCategoria(Request $request){
        $this->cors->corsJson();
        $categoriaRequest = $request->input('categoria');

        $id = intval($categoriaRequest->id);
        $categoria = ucfirst($categoriaRequest->categoria);
        $response = [];
        
        $dataCategoria = Categorias::find($id);
        
        if($categoriaRequest){
            if($dataCategoria){
                $dataCategoria->categoria = $categoria;
                $dataCategoria->save();
            
                $response=[
                    'status'=>true,
                    'mensaje'=>'Categoria se ha actualizado',
                    'categoria'=>$dataCategoria
                ];
            }else{
                $response=[
                    'status'=>true,
                    'mensaje'=>'No se pudo actualizar la categoria',
                    'categoria'=>null
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
            ];
        }
        echo json_encode($response);
    }

    public function graficoCategorias()
    {
        $this->cors->corsJson();
        $categoria = Categorias::where('estado', 'A')->get();

        $labels = [];  $data = [];  $dataPorcentaje = [];  $response = [];  $suma = 0;

        foreach ($categoria as $item) {
            $productos = $item->productos;
            $labels[] = $item->categoria;
            $data[] = count($productos);
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
                'labels' => $labels,
                'data' => $data,
                'porcentaje' => $dataPorcentaje,
            ],
        ];
        echo json_encode($response); die();

    }

}