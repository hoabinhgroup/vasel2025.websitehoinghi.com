<?php

namespace Modules\Analytics\Exceptions;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class InvalidConfiguration extends Exception
{
  /**
   * @return static
   * @throws FileNotFoundException
   */
  public static function viewIdNotSpecified()
  {
    return new static(
      trans("analytics::analytics.view_id_not_specified", [
        "version" => "1.1",
      ])
    );
  }

  /**
   * @return static
   * @throws FileNotFoundException
   */
  public static function credentialsIsNotValid()
  {
    return new static(
      trans("analytics::analytics.credential_is_not_valid", [
        "version" => "1.1",
      ])
    );
  }
}
