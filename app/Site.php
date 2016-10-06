<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Spatie\Activitylog\Traits\LogsActivity;

class Site extends Model
{
    //
    use Eloquence;

    protected $searchableColumns = [
        'mailing_address'     => 20,
        'billing_address'     => 20,
        'first_name'          => 15,
        'last_name'           => 15,
        'client.company_name' => 15,
        'client.first_name'   => 15,
        'client.last_name'    => 15,
        'cell_number'         =>15,
        'email'               =>15,
        'relationship'        => 10,
        'mailing_city'        => 10,
        'mailing_province'    => 10,
        'mailing_postalcode'  =>10,
        'billing_city'        => 10,
        'billing_province'    => 10,
        'billing_postalcode'  =>10,
        'work_number'         =>5,
        'fax_number'          =>5,
        'home_number'         =>2,
        'alternate_email'     =>2,
    ];

    // Log activity
    use LogsActivity;
    protected $fillable = [
        'first_name',
        'last_name',
        'relationship',
        'mailing_address',
        'mailing_city',
        'mailing_province',
        'mailing_postalcode',
        'buzzer_code',
        'billing_address',
        'billing_city',
        'billing_province',
        'billing_postalcode',
        'home_number',
        'cell_number',
        'work_number',
        'fax_number',
        'email',
        'alternate_email',
        'property_note',
        'client_id',
    ];
    protected static $logAttributes = [
        'first_name',
        'last_name',
        'relationship',
        'mailing_address',
        'mailing_city',
        'mailing_province',
        'mailing_postalcode',
        'buzzer_code',
        'billing_address',
        'billing_city',
        'billing_province',
        'billing_postalcode',
        'home_number',
        'cell_number',
        'work_number',
        'fax_number',
        'email',
        'alternate_email',
        'property_note',
        'client_id',
    ];

    /**
     * Get the jobs for the client.
     */
    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function siteSearchByKeyword($keyword)
    {
        $query = '';
        if ($keyword!='') {
            $query = $this->where("relationship",   "LIKE", "%$keyword%")
                    ->orWhere("first_name",         "LIKE", "%$keyword%")
                    ->orWhere("last_name",          "LIKE", "%$keyword%")
                    ->orWhere("mailing_address",    "LIKE", "%$keyword%")
                    ->orWhere("mailing_city",       "LIKE", "%$keyword%")
                    ->orWhere("mailing_province",   "LIKE", "%$keyword%")
                    ->orWhere("mailing_postalcode", "LIKE", "%$keyword%")
                    //->orWhere("buzzer_code",        "LIKE", "%$keyword%")
                    ->orWhere("billing_address",    "LIKE", "%$keyword%")
                    ->orWhere("billing_city",       "LIKE", "%$keyword%")
                    ->orWhere("billing_province",   "LIKE", "%$keyword%")
                    ->orWhere("billing_postalcode", "LIKE", "%$keyword%")
                    ->orWhere("home_number",        "LIKE", "%$keyword%")
                    ->orWhere("cell_number",        "LIKE", "%$keyword%")
                    ->orWhere("work_number",        "LIKE", "%$keyword%")
                    ->orWhere("fax_number",         "LIKE", "%$keyword%")
                    ->orWhere("email",              "LIKE", "%$keyword%")
                    ->orWhere("alternate_email",    "LIKE", "%$keyword%");
                    //->orWhere("created_at",         "LIKE", "%$keyword%")
                   // ->orWhere("updated_at",         "LIKE", "%$keyword%");
        }
        return $query;
    }
}
