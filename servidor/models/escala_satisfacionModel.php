<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';

require_once 'models/citasModel.php';

use Illuminate\Database\Eloquent\Model;

class Escala_Satisfacion extends Model{
    protected $table = 'escala_satisfacion'; //nombre de la tabla
    protected $fillable = ['detalle','valor','name_svg','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false


    //hasMany => uno a muchos
    public function citas(){
        return $this->hasMany(Citas::class,'id');
    }


    
}