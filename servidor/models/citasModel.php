<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/usuariosModel.php';
require_once 'models/doctoresModel.php';
require_once 'models/horarioModel.php';
require_once 'models/especialidadModel.php';
require_once 'models/pacientesModel.php';
require_once 'models/estado_citaModel.php';
require_once 'models/recetasModel.php';
require_once 'models/escala_satisfacionModel.php';




use Illuminate\Database\Eloquent\Model;

class Citas extends Model{
    protected $table = 'citas'; //nombre de la tabla
    protected $fillable = ['usuarios_id','doctores_id','horario_id','especialidad_id','pacientes_id','estado_cita_id','escala_satisfacion_id','fecha','h_entrada','h_salida','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function usuarios(){
        return $this->belongsTo(Usuarios::class);
    }

    //belongsTo => muchos a uno
    public function doctores(){
        return $this->belongsTo(Doctores::class);
    }

    //belongsTo => muchos a uno
    public function horario(){
        return $this->belongsTo(Horario::class);
    }

    //belongsTo => muchos a uno
    public function especialidad(){
        return $this->belongsTo(Especialidad::class);
    }

    //belongsTo => muchos a uno
    public function pacientes(){
        return $this->belongsTo(Pacientes::class);
    }

    //belongsTo => muchos a uno
    public function estado_cita(){
        return $this->belongsTo(Estado_Cita::class);
    }

    //belongsTo => muchos a uno
    public function escala_satisfacion(){
        return $this->belongsTo(Escala_Satisfacion::class);
    }

    //hasMany => uno a muchos
    public function recetas(){
        return $this->hasMany(Recetas::class);
    }


}