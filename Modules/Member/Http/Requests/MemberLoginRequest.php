<?php

namespace Modules\Member\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberLoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'   => 'required|email|max:255',
            'password' => 'required'
        ];
    }



  public function messages()
  {
    return [
      "required" => "Field :attribute required."
    ];
  }
}