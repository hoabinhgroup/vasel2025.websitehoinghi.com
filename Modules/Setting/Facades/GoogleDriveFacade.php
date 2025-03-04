<?php

namespace Modules\Setting\Facades;

use Modules\Setting\GoogleDrive;
use Illuminate\Support\Facades\Facade;

class GoogleDriveFacade extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   * @author Tuan Louis
   */
  protected static function getFacadeAccessor()
  {
    return GoogleDrive::class;
  }
}
