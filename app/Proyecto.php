<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model {
	public $primaryKey = 'id';
    public $table = 'proyectos';
    public $timestamps = false;
    public $fillable = ['nombre', 'descripcion'];

    public function imagenes(){
    	return $this->hasMany('App\imagen', 'proyectos_id', 'id');
    }
}