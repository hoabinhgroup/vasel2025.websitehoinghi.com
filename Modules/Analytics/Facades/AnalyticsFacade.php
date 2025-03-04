<?php

namespace Modules\Analytics\Facades;

use Modules\Analytics\Analytics;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Modules\Analytics\Analytics
 */
class AnalyticsFacade extends Facade
{
  /**
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return Analytics::class;
  }
}
