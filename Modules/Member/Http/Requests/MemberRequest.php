<?php

namespace Modules\Member\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'   => 'required|email|max:255|unique:members'
        ];
    }



  public function messages()
  {
    return [
      "required" => "Field :attribute required.",
      "unique" => "Duplicate :attribute, please enter other email!"
    ];
  }
}