<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/provinciaModel.php';
require_once 'models/campaniaModel.php';
require_once 'models/parroquiasModel.php';


use Illuminate\Database\Eloquent\Model;

class Cantones extends Model{
    protected $table = 'cantones'; //nombre de la tabla
    protected $fillable = ['provincia_id','nombre_canton','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function provincia(){
        return $this->belongsTo(Provincia::class);
    }

    //hasMany => uno a muchos
    public function campania(){
        return $this->hasMany(Campania::class);
    }

    //hasMany => uno a muchos
    public function parroquias(){
        return $this->hasMany(Parroquias::class);
    }


}