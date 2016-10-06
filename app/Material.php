<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    public function technician()
    {
        return $this->belongsTo('App\Technician');
    }
}
