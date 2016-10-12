<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    //
    public function estimate()
    {
        return $this->belongsTo('App\Estimate');
    }
}
