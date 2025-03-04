<?php

namespace App\Http\Requests;

//use Modules\Base\Enums\BaseStatusEnum;
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
      "fullname" => "required|max:255",
      "email" => "required|email|max:255|unique:attendances",
      "mobile" => "required"
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
