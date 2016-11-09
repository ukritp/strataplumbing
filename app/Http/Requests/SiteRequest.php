<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SiteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'company_name.*'     => 'max:255',
            'first_name.*'       => 'required|max:255',
            'last_name.*'        => 'max:255',
            'title.*'            => 'max:255',

            'mailing_address'    => 'required|max:255',
            'mailing_city'       => 'max:50',
            'mailing_province'   => '',
            'mailing_postalcode' => 'max:6',
            'buzzer_code'        => '',

            'billing_address'    => 'max:255',
            'billing_city'       => 'max:50',
            'billing_province'   => '',
            'billing_postalcode' => 'max:6',

            'home_number.*'      => 'digits:10',
            'cell_number.*'      => 'digits:10',
            'work_number.*'      => 'digits:10',
            'fax_number.*'       => 'digits:10',

            'email.*'            => 'email|max:255',
            'alternate_email.*'  => 'email|max:255',

            'property_note'      => '',
            'client_id'          => 'required|numeric'
        ];
    }
}
