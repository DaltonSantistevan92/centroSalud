<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/parroquiasModel.php';
require_once 'models/campaniaModel.php';



use Illuminate\Database\Eloquent\Model;

class Barrios extends Model{
    protected $table = 'barrios'; //nombre de la tabla
    protected $fillable = ['parroquias_id','nombre_barrio','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function parroquias(){
        return $this->belongsTo(Parroquias::class);
    }

    //hasMany => uno a muchos
    public function campania(){
        return $this->hasMany(Campania::class);
    }


}