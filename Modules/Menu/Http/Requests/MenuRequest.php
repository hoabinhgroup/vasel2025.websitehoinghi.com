<?php

namespace Modules\Menu\Http\Requests;

//use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:255',
            'slug'        => 'required|max:255',
           // 'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
    
    public function messages()
    {

        return [
			'name.required' => __('base::form-validate.title-require'),
			'slug.required' => __('base::form-validate.slug-require')
			];
    
    }
}
