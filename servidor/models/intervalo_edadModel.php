<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/campaniaModel.php';



use Illuminate\Database\Eloquent\Model;

class Intervalo_Edad extends Model{
    protected $table = 'intervalo_edad'; //nombre de la tabla
    protected $fillable = ['edad','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //hasMany => uno a muchos
    public function campania(){
        return $this->hasMany(Campania::class);
    }


}