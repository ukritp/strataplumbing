<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Many to Many Relationship - Role has many users
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id');
    }
}
