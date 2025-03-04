<?php
namespace Modules\Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'password'              => 'required|min:6|max:60',
            'password_confirmation' => 'same:password',
        ];

        if (Auth::user()) {
            return $rules;
        }

        return ['old_password' => 'required|min:6|max:60'] + $rules;
    }
}
