<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoinTrait;

class Gudang extends Model
{
	use EloquentJoinTrait;
	
    public function user()
    {
    	return $this->belongsTo('App\User', 'user_gudang_id');
    }

    public function items()
    {
    	return $this->belongsToMany('App\Item')->withPivot('amount');
    }
}
