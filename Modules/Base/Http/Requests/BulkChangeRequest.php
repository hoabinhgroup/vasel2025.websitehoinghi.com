<?php

namespace Modules\Base\Http\Requests;

use Modules\Base\Http\Requests\Request;

class BulkChangeRequest extends Request
{
  /**
   * @return array
   */
  public function rules()
  {
    return [
      "class" => "required",
    ];
  }
}
