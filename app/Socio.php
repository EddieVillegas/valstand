<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model {
	public $table = 'socios';
    public $fillable = ['nombre', 'portada'];
    public $timestamps = false;
}
