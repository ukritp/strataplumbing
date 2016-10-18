<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Estimate extends Model
{
    // Log activity
    use LogsActivity;
    protected $fillable = [
        'invoiced_from',
        'invoiced_to',
        'description',
        'cost',
        'job_id',
    ];
    protected static $logAttributes = [
        'invoiced_from',
        'invoiced_to',
        'description',
        'cost',
        'job_id',
    ];

    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    public function extras_table()
    {
        return $this->hasMany('App\Extra');
    }

    public function materials()
    {
        return $this->hasMany('App\Material');
    }
}
