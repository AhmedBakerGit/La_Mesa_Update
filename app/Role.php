<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function staffs()
    {
        return $this->hasMany('App\Staff');
        // return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    }
}
