<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Spatie\Activitylog\Traits\LogsActivity;

class Contact extends Model
{
    //
    // Search all column using Sofa Eloque
    use Eloquence;
    protected $searchableColumns = [
        'company_name'       => 15,
        'first_name'         => 15,
        'last_name'          => 15,
        'cell_number'        => 15,
        'email'              => 15,
        'title'              => 10,
        'work_number'        => 15,
        'fax_number'         => 15,
        'home_number'        => 15,
        'alternate_email'    => 15,
    ];


    /* ==========================================|| SET ATTRIBUTE ||==========================================*/
    /**
     * Always capitalize the first name when we save it to the database
     */
    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = ucfirst($value);
    }

    /**
     * Always capitalize the last name when we save it to the database
     */
    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = ucfirst($value);
    }

    /* ==========================================|| MODEL RELATIONSHIPS ||==========================================*/

    public function job()
    {
        return $this->belongsTo('App\Job');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    /* ==========================================|| OTHERS ||==========================================*/
    // format phone number
    public function formatPhone($phone_number) {
        $formatted_value = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone_number). "\n";
        if(!empty($formatted_value)){
            return $formatted_value;
        }else{
            return '-';
        }
    }

}
