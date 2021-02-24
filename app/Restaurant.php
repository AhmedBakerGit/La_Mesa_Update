<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function staffs()
    {
        return $this->hasMany('App\Staff');
    }

    public function menus()
    {
        return $this->hasMany('App\Menu');
    }

    public function tables()
    {
        return $this->hasMany('App\Table');
    }
}
