<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PendingInvoice extends Model
{
    // Log activity
    use LogsActivity;
    protected $fillable = [
        'description',
        'labor_description',
        'total_hours',
        'hourly_rates',
        'hourly_rates',
        'month',
        'year',
        'first_half_hour',
        'first_half_hour_amount',
        'first_one_hour',
        'first_one_hour_amount',
        'job_id',
    ];
    protected static $logAttributes = [
        'description',
        'labor_description',
        'total_hours',
        'hourly_rates',
        'hourly_rates',
        'month',
        'year',
        'first_half_hour',
        'first_half_hour_amount',
        'first_one_hour',
        'first_one_hour_amount',
        'job_id',
    ];


    public function technicians()
    {
        return $this->hasMany('App\Technician');
    }


    public function job()
    {
        return $this->belongsTo('App\Job');
    }

}
