<?php

namespace Modules\Registration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AbstractSubmissionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category'   => 'required',
            'session'   => '',
            'country'   => 'required',
            'abstract_title'   => 'required|max:150',
            'topic'   => 'required',
            'author'   => 'required',
            'title' => 'required',
            'titleOther' => 'required_if:title,other',
            'fullname' => 'required',
            'institution'   => 'required',
            'institution_full'   => 'required',
            'phone'   => 'required',
            'email'   => 'required',
            'abstract_file' => 'required|mimes:docx|max:8120',
            'passport' => 'required_if:category,1|mimes:pdf,jpg,jpeg,png|max:8120'
        ];
    }

    public function messages()
    {
        return [
            'passport.required_if' => 'The passport field is required when category is Faculty.'
        ];
    }
}
