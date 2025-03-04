<?php

namespace Modules\Registration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvitedRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'titleOther' => 'required_if:title,5',
            'fullname'   => 'required',
            'affiliation'   => 'required',
            'country' => 'required',
            'mobiphone'   => 'required',
            'position' => '',
            //'email'   => 'required|email',
            'dietary' => 'required',
            'dietaryOther' => 'required_if:dietary,other',
        ];
    }
    
    public function messages()
       {
           return [
               'titleOther.required_if' => 'Other. Please Specify is required',
               'dietaryOther.required_if' => 'Another dietary is required'
           ];
       }
}
