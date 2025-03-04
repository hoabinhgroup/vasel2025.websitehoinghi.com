<?php

namespace App\Http\Requests;

//use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class PhotoboothRequest extends FormRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "customer_code" => "required|numeric|loggedCheckin|unique_photobooth_entry:" .$this->input('photobooth_id')
    ];
  }

  public function messages()
  {
    return [
      "required" => "Field :attribute required.",
      "unique_photobooth_entry" => "You're already confirmed in at this photobooth before!",
      "logged_checkin" => "Your must checkin Qrcode before photobooths confirmed"
    ];
  }
}
