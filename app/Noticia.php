<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model {
    public $table = "noticias";
    public $fillable = ['caratula', 'tema', 'contenido', 'titulo'];

    public function scopeBuscar($query, $parametro){
    	if(trim($parametro) != ''){
	    	return $query->where('titulo','like','%$parametro%')
	    	->orWhere('tema','like', '%$parametro%')
	    	->orWhere('contenido','like', '%$parametro%')
	    	->get();
    	}
    }
}
