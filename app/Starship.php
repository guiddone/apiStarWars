<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Starship extends Model
{
    //protected $table= 'starships';
    public $incrementing=false;
    protected $fillable = ['id'];
}
