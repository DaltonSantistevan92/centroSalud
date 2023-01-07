<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/doctores_especialidadModel.php';
require_once 'models/citasModel.php';


use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model{
    protected $table = 'especialidad'; //nombre de la tabla
    protected $fillable = ['especialidad','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //hasMany => uno a muchos
    public function doctores_especialidad(){
        return $this->hasMany(Doctores_Especialidad::class);
    }

    //hasMany => uno a muchos
    public function citas(){
        return $this->hasMany(Citas::class);
    }

    
}