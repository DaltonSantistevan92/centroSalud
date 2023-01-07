<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/cantonesModel.php';
require_once 'models/campaniaModel.php';
require_once 'models/barriosModel.php';


use Illuminate\Database\Eloquent\Model;

class Parroquias extends Model{
    protected $table = 'parroquias'; //nombre de la tabla
    protected $fillable = ['cantones_id','nombre_parroquia','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function cantones(){
        return $this->belongsTo(Cantones::class);
    }

    //hasMany => uno a muchos
    public function campania(){
        return $this->hasMany(Campania::class);
    }

    //hasMany => uno a muchos
    public function barrios(){
        return $this->hasMany(Barrios::class);
    }


}