<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/campaniaModel.php';
require_once 'models/enfermeroModel.php';


use Illuminate\Database\Eloquent\Model;

class Campania_Enfermero extends Model{
    protected $table = 'campania_enfermero'; //nombre de la tabla
    protected $fillable = ['campania_id','enfermero_id','active','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function campania(){
        return $this->belongsTo(Campania::class);
    }

    //belongsTo => muchos a uno
    public function enfermero(){
        return $this->belongsTo(Enfermero::class);
    }

    
}