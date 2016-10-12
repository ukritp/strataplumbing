<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Estimate extends Model
{
    //
    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    public function extras_table()
    {
        return $this->hasMany('App\Extra');
    }
}
