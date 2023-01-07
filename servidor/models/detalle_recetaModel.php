<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/recetasModel.php';
require_once 'models/productosModel.php';



use Illuminate\Database\Eloquent\Model;

class Detalle_Receta extends Model{
    protected $table = 'detalle_receta'; //nombre de la tabla
    protected $fillable = ['recetas_id','productos_id','cantidad'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function recetas(){
        return $this->belongsTo(Recetas::class);
    }
    
    //belongsTo => muchos a uno
    public function productos(){
        return $this->belongsTo(Productos::class);
    }

    
}