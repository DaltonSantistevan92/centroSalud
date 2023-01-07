<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/enfermeroModel.php';
require_once 'models/campaniaModel.php';
require_once 'models/pacientesModel.php';


use Illuminate\Database\Eloquent\Model;

class Aplicar_Vacuna extends Model{
    protected $table = 'aplicar_vacuna'; //nombre de la tabla
    protected $fillable = ['enfermero_id','campania_id','pacientes_id','total_vacuna','total_aplicadas','total_restante','fecha','hora','estado'];//atributos de las tablas
    

    //belongsTo => muchos a uno
    public function enfermero(){
        return $this->belongsTo(Enfermero::class);
    }

    //belongsTo => muchos a uno
    public function campania(){
        return $this->belongsTo(Campania::class);
    }

    //belongsTo => muchos a uno
    public function pacientes(){
        return $this->belongsTo(Pacientes::class);
    }



}