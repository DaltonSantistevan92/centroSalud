<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/campaniaModel.php';
require_once 'models/productosModel.php';


use Illuminate\Database\Eloquent\Model;

class Detalle_Campania extends Model{
    protected $table = 'detalle_campania'; //nombre de la tabla
    protected $fillable = ['campania_id','productos_id','cantidad'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function campania(){
        return $this->belongsTo(Campania::class);
    }

    //belongsTo => muchos a uno
    public function productos(){
        return $this->belongsTo(Productos::class);
    }

    
}