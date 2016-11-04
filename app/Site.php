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
        'mailing_address'         => 20,
        'billing_address'         => 20,
        'contacts.first_name'      => 15,
        'contacts.last_name'       => 15,
        'client.company_name'     => 15,
        'client.first_name'       => 15,
        'client.last_name'        => 15,
        'contacts.cell_number'     =>15,
        'contacts.email'           =>15,
        'contacts.title'           => 10,
        'mailing_city'            => 10,
        'mailing_province'        => 10,
        'mailing_postalcode'      =>10,
        'billing_city'            => 10,
        'billing_province'        => 10,
        'billing_postalcode'      =>10,
        'contacts.work_number'     =>15,
        'contacts.fax_number'      =>15,
        'contacts.home_number'     =>15,
        'contacts.alternate_email' =>2,
    ];

    // Log activity
    use LogsActivity;
    protected $fillable = [
        // 'first_name',
        // 'last_name',
        // 'relationship',
        'mailing_address',
        'mailing_city',
        'mailing_province',
        'mailing_postalcode',
        'alarm_code',
        'lock_box',
        'lock_box_location',
        'buzzer_code',
        'billing_address',
        'billing_city',
        'billing_province',
        'billing_postalcode',
        // 'home_number',
        // 'cell_number',
        // 'work_number',
        // 'fax_number',
        // 'email',
        // 'alternate_email',
        'property_note',
        'client_id',
    ];
    protected static $logAttributes = [
        // 'first_name',
        // 'last_name',
        // 'relationship',
        'mailing_address',
        'mailing_city',
        'mailing_province',
        'mailing_postalcode',
        'alarm_code',
        'lock_box',
        'lock_box_location',
        'buzzer_code',
        'billing_address',
        'billing_city',
        'billing_province',
        'billing_postalcode',
        // 'home_number',
        // 'cell_number',
        // 'work_number',
        // 'fax_number',
        // 'email',
        // 'alternate_email',
        'property_note',
        'client_id',
    ];

    /* ==========================================|| SET ATTRIBUTE ||==========================================*/

    /**
     * Always capitalize the the first letter of every word in Address when we save it to the database
     */
    public function setMailingAddressAttribute($value) {
        $this->attributes['mailing_address'] = ucwords(strtolower($value));
    }

    /**
     * Always capitalize the the first letter of every word in City when we save it to the database
     */
    public function setMailingCityAttribute($value) {
        $this->attributes['mailing_city'] = ucwords(strtolower($value));
    }

    /**
     * Always capitalize all letter in Province when we save it to the database
     */
    public function setMailingProvinceAttribute($value) {
        $this->attributes['mailing_province'] = strtoupper($value);
    }

    /**
     * Always capitalize all letter in Postalcode when we save it to the database
     */
    public function setMailingPostalcodeAttribute($value) {
        $this->attributes['mailing_postalcode'] = strtoupper($value);
    }

    /**
     * Always capitalize the the first letter of every word in Address when we save it to the database
     */
    public function setBillingAddressAttribute($value) {
        $this->attributes['billing_address'] = ucwords(strtolower($value));
    }

    /**
     * Always capitalize the the first letter of every word in City when we save it to the database
     */
    public function setBillingCityAttribute($value) {
        $this->attributes['billing_city'] = ucwords(strtolower($value));
    }

    /**
     * Always capitalize all letter in Province when we save it to the database
     */
    public function setBillingProvinceAttribute($value) {
        $this->attributes['billing_province'] = strtoupper($value);
    }

    /**
     * Always capitalize all letter in Postalcode when we save it to the database
     */
    public function setBillingPostalcodeAttribute($value) {
        $this->attributes['billing_postalcode'] = strtoupper($value);
    }


    /* ==========================================|| GET ATTRIBUTE ||==========================================*/
    /**
     * Always put ',' after Address if not empty
     */
    public function getMailingAddressAttribute($value) {
        if(!empty($value)){
            return $value.'';
        }else{
            return $value;
        }
    }

    /**
     * Always put ',' after City if not empty
     */
    public function getMailingCityAttribute($value) {
        if(!empty($value)){
            return $value.'';
        }else{
            return $value;
        }
    }

    /**
     * Always put space after Province if not empty
     */
    public function getMailingProvinceAttribute($value) {
        if(!empty($value)){
            return $value.'';
        }else{
            return $value;
        }
    }

    /**
     * Always capitalize all letter in Postalcode when we save it to the database
     */
    public function getMailingPostalcodeAttribute($value) {
        return strtoupper($value);
    }

    /**
     * Always put ',' after Address if not empty
     */
    public function getBillingAddressAttribute($value) {
        if(!empty($value)){
            return $value.'';
        }else{
            return $value;
        }
    }

    /**
     * Always put ',' after City if not empty
     */
    public function getBillingCityAttribute($value) {
        if(!empty($value)){
            return $value.'';
        }else{
            return $value;
        }
    }

    /**
     * Always put space after Province if not empty
     */
    public function getBillingProvinceAttribute($value) {
        if(!empty($value)){
            return $value.'';
        }else{
            return $value;
        }
    }

    /**
     * Always capitalize all letter in Postalcode when we save it to the database
     */
    public function getBillingPostalcodeAttribute($value) {
        return strtoupper($value);
    }

    /* ==========================================|| MODEL RELATIONSHIPS ||==========================================*/
    /**
     * Get the jobs for the client.
     */
    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /* ==========================================|| OTHERS ||==========================================*/

    // get full address
    public function fullMailingAddress()
    {
        $full_address = '';
        if(!empty($this->mailing_address)){
            $full_address .= $this->mailing_address.', ';
        }
        if(!empty($this->mailing_city)){
            $full_address .= $this->mailing_city.', ';
        }
        if(!empty($this->mailing_province)){
            $full_address .= $this->mailing_province.' ';
        }
        $full_address .= wordwrap(strtoupper($this->mailing_postalcode) , 3 , ' ' , true );
        return $full_address;
    }

    // get full address
    public function fullBillingAddress()
    {
        $full_address = '';
        if(!empty($this->billing_address)){
            $full_address .= $this->billing_address.', ';
        }
        if(!empty($this->billing_city)){
            $full_address .= $this->billing_city.', ';
        }
        if(!empty($this->billing_province)){
            $full_address .= $this->billing_province.' ';
        }
        $full_address .= wordwrap(strtoupper($this->billing_postalcode) , 3 , ' ' , true );
        return $full_address;
    }

    // format phone number
    public function formatPhone($phone_number) {
        $formatted_value = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone_number). "\n";
        if(!empty($formatted_value)){
            return $formatted_value;
        }else{
            return '-';
        }
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
