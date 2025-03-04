<?php

namespace Modules\Registration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
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
            'phone'   => 'required',
            'country' => '',
            'category_id' => 'required',
            'dietary' => 'required',
            'dietaryOther' => 'required_if:dietary,other',
            'payment_method' => 'required',
           // 'conference_checklist_payload' => 'required',
        ];
    }
    
   public function messages()
   {
       return [
           'conference_checklist_item.required_with' => 'Please chosen 1 category',
           'titleOther.required_if' => 'Other. Please Specify is required',
           'dietaryOther.required_if' => 'Another dietary is required'
       ];
   }
   
   }
