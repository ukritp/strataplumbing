<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Spatie\Activitylog\Traits\LogsActivity;

class Technician extends Model
{
    //
    use Eloquence;

    protected $searchableColumns = [
        'technician_name'            => 20,
        'job.project_manager'        => 20,
        'job.client.company_name'    => 10,
        'job.client.first_name'      => 10,
        'job.client.last_name'       => 10,
        'job.client.mailing_address' => 10,
        'job.site.mailing_address'   => 10,
        'job.client.mailing_city'    => 10,
        'job.site.mailing_city'      => 10,
        'tech_details'               => 10,
        'job.site.first_name'        => 5,
        'job.site.last_name'         => 5,
        'tech_details'               => 5,
    ];

    // Log activity
    use LogsActivity;
    protected $fillable = [
        'pendinginvoiced_at',
        'technician_name',
        'tech_details',
        'flushing_hours',
        'camera_hours',
        'main_line_auger_hours',
        'other_hours',
        'flushing_hours_cost',
        'camera_hours_cost',
        'main_line_auger_hours_cost',
        'other_hours_cost',
        'notes',
        'equipment_left_on_site',
        'equipment_name',
        'job_id',
        'pending_invoice_id',
    ];
    protected static $logAttributes = [
        'pendinginvoiced_at',
        'technician_name',
        'tech_details',
        'flushing_hours',
        'camera_hours',
        'main_line_auger_hours',
        'other_hours',
        'flushing_hours_cost',
        'camera_hours_cost',
        'main_line_auger_hours_cost',
        'other_hours_cost',
        'notes',
        'equipment_left_on_site',
        'equipment_name',
        'job_id',
        'pending_invoice_id',
    ];

    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    public function pendinginvoice()
    {
        return $this->belongsTo('App\PendingInvoice');
    }

    public function materials()
    {
        return $this->hasMany('App\Material');
    }

    public function revisions()
    {
        return $this->hasMany('App\Revision');
    }

    public function technicianSearchByKeyword($keyword)
    {
        $query = '';
        if ($keyword!='') {
            $equipment = 0;
            if($keyword == 'not'){
                $equipment = 0;
            }else if($keyword == 'yes' ){
                $equipment = 1;
            }
            $query = $this->where("technician_name",          "LIKE", "%$keyword%")
                    //->orWhere("tech_details",                 "LIKE", "%$keyword%")
                    //->orWhere("flushing_hours",               "LIKE", "%$keyword%")
                    //->orWhere("camera_hours",                 "LIKE", "%$keyword%")
                    //->orWhere("big_auger_hours",              "LIKE", "%$keyword%")
                    //->orWhere("small_and_medium_auger_hours", "LIKE", "%$keyword%")
                    //->orWhere("notes",                        "LIKE", "%$keyword%")
                    ->orWhere("equipment_left_on_site",       "LIKE", "%$equipment%")
                    ->orWhere("equipment_name",               "LIKE", "%$keyword%")
                    ->orWhere("created_at",                   "LIKE", "%$keyword%")
                    ->orWhere("updated_at",                   "LIKE", "%$keyword%");
        }
        return $query;
    }
}
