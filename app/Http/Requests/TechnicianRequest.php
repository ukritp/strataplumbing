<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TechnicianRequest extends Request
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
            'pendinginvoiced_at'     => '',
            'technician_name'        => 'required',
            'tech_details'           => 'required',

            'material_name.*'        => '',
            'material_quantity.*'    => 'numeric',

            'flushing_hours'         => 'numeric',
            'camera_hours'           => 'numeric',
            'main_line_auger_hours'  => 'numeric',
            'other_hours'            => 'numeric',
            'notes'                  => '',
            'equipment_left_on_site' => 'required',
            'equipment_name'         => '',
            'job_id'                 => 'required|numeric'
        ];
    }
}
