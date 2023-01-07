<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/doctoresModel.php';
require_once 'models/horarioModel.php';

use Illuminate\Database\Eloquent\Model;

class Doctor_Horario extends Model
{

    protected $table = "doctor_horario"; // nombre de la tabla
    protected $filleable = ['doctores_id','horario_id','estado'];//atributos de las tablas
    public $timestamps = false; //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function doctores()
    {
        return $this->belongsTo(Doctores::class);
    }
    
    //belongsTo => muchos a uno
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

}
