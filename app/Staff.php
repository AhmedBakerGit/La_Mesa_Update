<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $guard = 'staff';

    protected $fillable = [
        'f_name', 'l_name', 'name', 'password', 'role_id', 'restaurant_id', 'contact'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
