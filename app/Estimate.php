<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Spatie\Activitylog\Traits\LogsActivity;

class Estimate extends Model
{
    // Search all column using Sofa Eloque
    use Eloquence;
    protected $searchableColumns = [
        'description' => 15,
        'cost'        => 15,
        'extras_table.extras_description' => 15,
        'extras_table.extras_cost'        => 15,
    ];

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

    // gotta be extras_table bcoz it seems to have conflict with default Laravel
    public function extras_table()
    {
        return $this->hasMany('App\Extra');
    }

    public function materials()
    {
        return $this->hasMany('App\Material');
    }
}
