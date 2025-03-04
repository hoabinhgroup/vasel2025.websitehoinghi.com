<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\MacroableModels;
use Illuminate\Support\Facades\Facade;

class MacroableModelsFacade extends Facade
{
  /**
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return MacroableModels::class;
  }
}
