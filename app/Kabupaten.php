<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    public function propinsi()
    {
    	return $this->belongsTo('App\Propinsi');
    }
}
