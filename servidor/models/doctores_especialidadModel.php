<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/doctoresModel.php';
require_once 'models/especialidadModel.php';

use Illuminate\Database\Eloquent\Model;

class Doctores_Especialidad extends Model
{

    protected $table = "doctores_especialidad"; // nombre de la tabla
    protected $filleable = ['doctores_id','especialidad_id','estado'];//atributos de las tablas
    public $timestamps = false; //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function doctores()
    {
        return $this->belongsTo(Doctores::class);
    }
    
    //belongsTo => muchos a uno
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

}
