<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/provinciaModel.php';
require_once 'models/cantonesModel.php';
require_once 'models/parroquiasModel.php';
require_once 'models/barriosModel.php';
require_once 'models/intervalo_edadModel.php';
require_once 'models/movimientosModel.php';
require_once 'models/campania_enfermeroModel.php';
require_once 'models/detalle_campaniaModel.php';
require_once 'models/aplicar_vacunaModel.php';



use Illuminate\Database\Eloquent\Model;

class Campania extends Model{
    protected $table = 'campania'; //nombre de la tabla
    protected $fillable = ['nombre','provincia_id','cantones_id','parroquias_id','barrios_id','intervalo_edad_id','fecha','asignacion','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo => muchos a uno
    public function provincia(){
        return $this->belongsTo(Provincia::class);
    }

    //belongsTo => muchos a uno
    public function cantones(){
        return $this->belongsTo(Cantones::class);
    }

    //belongsTo => muchos a uno
    public function parroquias(){
        return $this->belongsTo(Parroquias::class);
    }

    //belongsTo => muchos a uno
    public function barrios(){
        return $this->belongsTo(Barrios::class);
    }

    //belongsTo => muchos a uno
    public function intervalo_edad(){
        return $this->belongsTo(Intervalo_Edad::class);
    }

    //hasMany => uno a muchos
    public function movimientos(){
        return $this->hasMany(Movimientos::class);
    }

    //hasMany => uno a muchos
    public function campania_enfermero(){
        return $this->hasMany(Campania_Enfermero::class);
    }

    //hasMany => uno a muchos
    public function detalle_campania(){
        return $this->hasMany(Detalle_Campania::class);
    }

    //hasMany => uno a muchos
    public function aplicar_vacuna(){
        return $this->hasMany(Aplicar_Vacuna::class);
    }



}