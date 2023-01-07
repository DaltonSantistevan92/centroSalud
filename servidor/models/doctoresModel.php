<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/personasModel.php';
require_once 'models/doctor_horarioModel.php';
require_once 'models/citasModel.php';
require_once 'models/doctores_especialidadModel.php';



use Illuminate\Database\Eloquent\Model; 


class Doctores extends Model{
    protected $table = 'doctores'; // nombre de la tabla
    protected $fillable = ['personas_id','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function personas(){
        return $this->belongsTo(Personas::class);
    }

    //hasMany => uno a muchos
    public function doctor_horario(){
        return $this->hasMany(Doctor_Horario::class);
    }

    //hasMany => uno a muchos
    public function citas(){
        return $this->hasMany(Citas::class);
    }

    //hasMany => uno a muchos
    public function doctores_especialidad(){
        return $this->hasMany(Doctores_Especialidad::class);
    }



}