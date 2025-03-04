<?php

namespace Modules\Post\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "name" => "required",
      "slug" => "required|max:255",
      // 'description' => 'max:400',
      "content" => "required",
      "categories" => "required",
    ];
  }

  public function messages()
  {
    return [
      "name.required" => __("base::form-validate.title-require"),
      "categories.required" => __("base::form-validate.categories-require"),
      "slug.required" => __("base::form-validate.slug-require"),
    ];
  }
}
