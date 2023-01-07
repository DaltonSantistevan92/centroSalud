<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/usuariosModel.php';
require_once 'models/proveedoresModel.php';
require_once 'models/detalle_abastecerModel.php';


use Illuminate\Database\Eloquent\Model;

class Abastecer extends Model{
    protected $table = 'abastecer'; //nombre de la tabla
    protected $fillable = ['usuarios_id','proveedores_id','serie','fecha','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //belongsTo =>muchos a uno
    public function usuarios(){
        return $this->belongsTo(Usuarios::class);
    }

    //belongsTo =>muchos a uno
    public function proveedores(){
        return $this->belongsTo(Proveedores::class);
    }

    //hasMany => uno a muchos
    public function detalle_abastecer(){
        return $this->hasMany(Detalle_Abastecer::class);
    }

    
}