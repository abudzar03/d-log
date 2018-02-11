<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User', 'user_perusahaan_id');
    }

    public function gudangs()
    {
    	return $this->belongsToMany('App\Gudang')->withPivot('amount');
    }
}
