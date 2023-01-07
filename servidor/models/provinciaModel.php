<?php
require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/campaniaModel.php';
require_once 'models/cantonesModel.php';




use Illuminate\Database\Eloquent\Model;

class Provincia extends Model{
    protected $table = 'provincia'; //nombre de la tabla
    protected $fillable = ['nombre_provincia','estado'];//atributos de las tablas
    public $timestamps = false;  //los created_at y updated_at los pones false

    //hasMany => uno a muchos
    public function campania(){
        return $this->hasMany(Campania::class);
    }

    //hasMany => uno a muchos
    public function cantones(){
        return $this->hasMany(Cantones::class);
    }


}