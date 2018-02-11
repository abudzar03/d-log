<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoinTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use EloquentJoinTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'alamat', 'propinsi_id', 'kabupaten_id', 'nomor_telepon'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function propinsi()
    {
        return $this->hasOne('App\Propinsi');
    }

    public function kabupaten()
    {
        return $this->hasOne('App\Kabupaten');
    }

    public function items()
    {
        return $this->hasMany('App\Item', 'user_perusahaan_id');
    }

    public function gudang()
    {
        return $this->hasOne('App\Gudang', 'user_gudang_id');
    }
}
