<?php

namespace Modules\Page\Http\Requests;

//use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "name" => "required|max:255",
      "description" => "max:400",
      "content" => "required",
      "image" => "required",
      "slug" => "required|max:255",
      // 'status'      => Rule::in(BaseStatusEnum::values()),
    ];
  }

  public function messages()
  {
    return [
      "name.required" => __("base::form-validate.title-require"),
      "template.required" => __("base::form-validate.categories-require"),
      "slug.required" => __("base::form-validate.slug-require"),
    ];
  }
}
