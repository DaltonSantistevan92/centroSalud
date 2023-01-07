<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/personasModel.php';

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model{
    protected $table = 'sexo'; //nombre de la tabla
    protected $fillable = ['tipo','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //hasMany => uno a muchos
    public function personas(){
        return $this->hasMany(Personas::class);
    }


}