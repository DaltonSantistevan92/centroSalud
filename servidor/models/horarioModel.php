<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/doctor_horarioModel.php';
require_once 'models/citasModel.php';


use Illuminate\Database\Eloquent\Model;


class Horario extends Model{
    protected $table = 'horario'; // nombre de la tabla
    protected $fillable = ['hora_entrada','hora_salida','fecha','intervalo','hora_atencion','libre','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //hasMany => uno a muchos
    public function doctor_horario(){
        return $this->hasMany(Doctor_Horario::class);
    }

    //hasMany => uno a muchos
    public function citas(){
        return $this->hasMany(Citas::class);
    }

}