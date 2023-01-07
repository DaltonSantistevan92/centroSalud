<?php

class Helper
{

    public static function save_file($file, $path)
    {

        $response = [];
        $imagen = $file;
        $target_path = $path;
        $target_path = $target_path . basename($imagen['name']);

        $enlace_actual = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        $enlace_actual = str_replace('index.php', '', $enlace_actual);

        $response = [];

        if (move_uploaded_file($imagen['tmp_name'], $target_path)) {
            $response = [
                'status' => true,
                'mensaje' => 'Fichero subido',
                'imagen' => $imagen['name'],
                'direccion' => $enlace_actual . '/' . $target_path,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se pudo guardar el fichero',
                'imagen' => null,
                'direccion' => null,
            ];
        }

        return ($response);
    }

    public function generate_key($limit){
        $key = '';

        $aux = sha1(md5(time()));
        $key = substr($aux, 0, $limit);

        return $key;
    }

    public static function mes($pos){
        $pos = intval($pos) -1;

        $array = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        return $array[$pos];
    }

    public static function MESES(){
        $m = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        return $m;
    }
    public static function invertir_array($array){

        $copia = [];

        for($i = 0; $i < count($array); $i++){
            $copia[] = $array[count($array) - $i  - 1];
        }

        return $copia;
    }

}
