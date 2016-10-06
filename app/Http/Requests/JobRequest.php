<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class JobRequest extends Request
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
            'scope_of_works'  =>  'required',
            'project_manager' =>  'required',
            'site_id'         =>  'numeric',
            'client_id'       =>  'required|numeric'
        ];
    }
}
