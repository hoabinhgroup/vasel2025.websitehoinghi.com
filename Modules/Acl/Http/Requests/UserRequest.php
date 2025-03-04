<?php

namespace Modules\Acl\Http\Requests;

//use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'email' => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
           // 'status'      => Rule::in(BaseStatusEnum::values()),
        ];
    }
    
    public function messages()
    {

        return [
			'name.required' => __('base::form-validate.title-require'),
			'email.required' => __('base::form-validate.email-require'),
			'first_name.required' => __('base::form-validate.first_name-require'),
			'last_name.required' => __('base::form-validate.last_name-require')
			];
    
    }
}
