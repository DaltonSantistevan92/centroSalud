<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/sexoModel.php';
require_once 'models/usuariosModel.php';
require_once 'models/doctoresModel.php';
require_once 'models/pacientesModel.php';
require_once 'models/enfermeroModel.php';




use Illuminate\Database\Eloquent\Model;

class Personas extends Model{
    protected $table = 'personas'; // nombre de la tabla
    protected $fillable = ['cedula','nombre','apellido','num_celular','direccion','sexo_id','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function sexo(){
        return $this->belongsTo(Sexo::class);
    }

    //hasMany => uno a muchos
    public function usuarios(){
        return $this->hasMany(Usuarios::class);
    }

    //hasMany => uno a muchos
    public function doctores(){
        return $this->hasMany(Doctores::class);
    }

    //hasMany => uno a muchos
    public function pacientes(){
        return $this->hasMany(Pacientes::class);
    }

    //hasMany => uno a muchos
    public function enfermero(){
        return $this->hasMany(Enfermero::class);
    }


}