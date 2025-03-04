<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\SiteMapManager;
use Illuminate\Support\Facades\Facade;

class SiteMapManagerFacade extends Facade
{
  /**
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return SiteMapManager::class;
  }
}
