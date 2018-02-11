<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propinsi extends Model
{
    public function kabupatens() 
    {
    	return $this->hasMany('App\Kabupaten');
    }
}
