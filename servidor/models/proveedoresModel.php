<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/abastecerModel.php';



use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model{
    protected $table = 'proveedores'; //nombre de la tabla
    protected $fillable = ['nombre_proveedor','ruc','correo','direccion','telefono','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false


    //hasMany => uno a muchos
    public function abastecer(){
        return $this->hasMany(Abastecer::class);
    }

    
}