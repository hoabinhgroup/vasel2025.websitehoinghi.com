<?php

namespace Modules\Acl\Http\Requests;

//use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserGroupRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:255'
        ];
    }
    
    public function messages()
    {

        return [
			'name.required' => __('base::form-validate.title-require')
			];
    
    }
}
