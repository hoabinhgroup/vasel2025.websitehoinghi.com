<?php

namespace Modules\Registration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FullpaperSubmissionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'required',
            'paper_title' => 'required|max:150',
            'titleOther' => 'required_if:title,other',
            'fullname' => 'required',
            'email' => 'required',
            'country' => 'required',
            'passport' => 'required|mimes:pdf,jpg,jpeg,png|max:8120',
            'attach_fullpaper' => 'required|mimes:docx|max:8120',
        ];
    }

    public function messages()
    {
        return [];
    }
}
