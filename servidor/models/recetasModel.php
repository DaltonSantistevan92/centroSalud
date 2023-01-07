<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/citasModel.php';
require_once 'models/detalle_recetaModel.php';



use Illuminate\Database\Eloquent\Model;

class Recetas extends Model{
    protected $table = 'recetas'; //nombre de la tabla
    protected $fillable = ['citas_id','entregado','fecha','descripcion','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function citas(){
        return $this->belongsTo(Citas::class);
    }

    //hasMany => uno a muchos
    public function detalle_receta(){
        return $this->hasMany(Detalle_Receta::class);
    } 

    
}