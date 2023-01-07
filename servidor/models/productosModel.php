<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/categoriasModel.php';
require_once 'models/detalle_recetaModel.php';
require_once 'models/detalle_abastecerModel.php';
require_once 'models/inventarioModel.php';

use Illuminate\Database\Eloquent\Model;

class Productos extends Model{
    protected $table = 'productos'; //nombre de la tabla
    protected $fillable = ['categorias_id','codigo','nombre','descripcion','imagen','stock','fecha','d_campania','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function categorias(){
        return $this->belongsTo(Categorias::class);
    }

    //hasMany => uno a muchos
    public function detalle_receta(){
        return $this->hasMany(Detalle_Receta::class);
    }
    
    //hasMany => uno a muchos
    public function detalle_abastecer(){
        return $this->hasMany(Detalle_Abastecer::class);
    }

    //hasMany => uno a muchos
    public function inventario(){
        return $this->hasMany(Inventario::class);
    }

    
}