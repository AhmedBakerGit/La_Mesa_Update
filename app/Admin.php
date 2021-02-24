<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'f_name', 'l_name', 'name', 'email', 'password', 'contact', 'company', 'comaddress', 'comcontact'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function restaurants()
    {
        return $this->hasMany('App\Restaurant');
    }
}
