<?php

namespace Modules\Acl\Http\Requests;

//use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuestRegisterRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed'
        ];
    }
    
    public function messages()
    {

        return [
			'name.required' => __('base::form-validate.title-require'),
			'email.required' => __('base::form-validate.email-require'),
			'password.required' => 'Yêu cầu nhập mât khẩu'
			];
    
    }
}
