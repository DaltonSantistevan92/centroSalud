<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/personasModel.php';
require_once 'models/citasModel.php';
require_once 'models/aplicar_vacunaModel.php';



use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model{
    protected $table = 'pacientes'; //nombre de la tabla
    protected $fillable = ['personas_id','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function personas(){
        return $this->belongsTo(Personas::class);
    }
    
    //hasMany => uno a muchos
    public function citas(){
        return $this->hasMany(Citas::class);
    }

    //hasMany => uno a muchos
    public function aplicar_vacuna(){
        return $this->hasMany(Aplicar_Vacuna::class);
    }


}