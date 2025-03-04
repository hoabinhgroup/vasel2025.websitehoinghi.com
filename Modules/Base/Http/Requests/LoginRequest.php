<?php

namespace Modules\Base\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
      public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }
    
     public function messages()
    {
        return [
            'email.required' => 'Xin vui lòng nhập Email',
            'password.required' => 'Xin vui lòng nhập mật khẩu'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
