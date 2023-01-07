<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/citasModel.php';



use Illuminate\Database\Eloquent\Model;

class Estado_Cita extends Model{
    protected $table = 'estado_cita'; //nombre de la tabla
    protected $fillable = ['detalle','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //hasMany => uno a muchos
    public function citas(){
        return $this->hasMany(Citas::class,'estado_cita_id');
    }


}