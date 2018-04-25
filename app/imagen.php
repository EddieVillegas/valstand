<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class imagen extends Model
{
    public $primaryKey = 'id';
    public $table = 'imagenes';
    public $timestamps = false;
    public $fillable = ['nombre'];
}