<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subasta extends Model {
    public $table = 'subastas';
    public $fillable = ['nombre', 'caratula', 'descripcion'];
    public $timestamps = false;

    public function scopeBuscar($query, $parametro){
    	if(trim($parametro) != '') {
	    	return $query->where('nombre', 'like', "%$parametro%")
	    	->orWhere('descripcion','like', "%$parametro%")
	    	->orWhere('status','like', "%$parametro%")
	    	->get();
    	}
    }
}