<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model {
    
    public $table = "administradores";
    public $fillable = ['nombre', 'apellido_paterno', 'apellido_materno', 'email', 'usuario', 'password'];
    public $timestamps = false;
    protected $hidden = ['password'];

    public function scopeBuscar($query, $parametro){
    	if(trim($parametro) != ''){
            return $query->where('nombre', 'like', "%$parametro%")
            ->orWhere('apellido_paterno', 'like', "%$parametro%")
            ->orWhere('apellido_materno', 'like', "%$parametro%")
            ->orWhere('email', 'like', "%$parametro%")
            ->orWhere('usuario', 'like', "%$parametro%")
            ->get();
        }
    }

    public function scopeActivos($query){
        return $query->orderby('id','asc')->paginate(5);
    }
}
