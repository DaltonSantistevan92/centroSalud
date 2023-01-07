<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/recetasModel.php';
require_once 'models/abastecerModel.php';
require_once 'models/campaniaModel.php';
require_once 'models/movimientosModel.php';


use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model{
    protected $table = 'movimientos'; //nombre de la tabla
    protected $fillable = ['tipo_movimiento','recetas_id','abastecer_id','campania_id','fecha'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function recetas(){
        return $this->belongsTo(Recetas::class);
    }

    //belongsTo => muchos a uno
    public function abastecer(){
        return $this->belongsTo(Abastecer::class);
    }

    //belongsTo => muchos a uno
    public function campanias(){
        return $this->belongsTo(Campania::class);
    }

    //hasMany => uno a muchos
    public function inventario(){
        return $this->hasMany(Inventario::class);
    }
}