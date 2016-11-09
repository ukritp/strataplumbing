<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Spatie\Activitylog\Traits\LogsActivity;

//https://laracasts.com/discuss/channels/laravel/search-option-in-laravel-5?page=1

class Client extends Model
{
    // Search all column using Sofa Eloque
    use Eloquence;
    protected $searchableColumns = [
        'mailing_address'    => 20,
        'billing_address'    => 20,
        'company_name'       => 15,
        'first_name'         => 15,
        'last_name'          => 15,
        'cell_number'        => 15,
        'email'              => 15,
        'title'              => 15,
        'mailing_city'       => 15,
        'mailing_province'   => 10,
        'mailing_postalcode' => 10,
        'billing_city'       => 15,
        'billing_province'   => 10,
        'billing_postalcode' => 10,
        'work_number'        => 15,
        'fax_number'         => 15,
        'home_number'        => 15,
        'alternate_email'    => 15,
    ];

    // Log activity
    use LogsActivity;
    protected $fillable = [
        'company_name',
        'first_name',
        'last_name',
        'title',
        'mailing_address',
        'mailing_city',
        'mailing_province',
        'mailing_postalcode',
        'buzzer_code',
        'alarm_code',
        'lock_box',
        'lock_box_location',
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
        'quoted_rates',
        'property_note',
    ];
    protected static $logAttributes = [
        'company_name',
        'first_name',
        'last_name',
        'title',
        'mailing_address',
        'mailing_city',
        'mailing_province',
        'mailing_postalcode',
        'buzzer_code',
        'alarm_code',
        'lock_box',
        'lock_box_location',
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
        'quoted_rates',
        'property_note',
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
            return $value.' ';
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
     * Get the sites for the client.
     */
    public function sites()
    {
        return $this->hasMany('App\Site');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
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


    public function clientSearchByKeyword($keyword)
    {
        $query = '';
        if ($keyword!='') {
            $query = $this->where("company_name",       "LIKE", "%$keyword%")
                    ->orWhere("first_name",         "LIKE", "%$keyword%")
                    ->orWhere("last_name",          "LIKE", "%$keyword%")
                    ->orWhere("title",              "LIKE", "%$keyword%")
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
                    //->orWhere("updated_at",         "LIKE", "%$keyword%");
        }
        return $query;
    }
}
