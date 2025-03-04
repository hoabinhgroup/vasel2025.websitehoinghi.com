<?php

namespace Modules\Slider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderItemRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "slider_id" => "required",
      "title" => "required",
      "image" => "required",
      "order" => "required|integer|min:0",
    ];
  }
}
