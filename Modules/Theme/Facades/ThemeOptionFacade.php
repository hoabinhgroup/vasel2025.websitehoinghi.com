<?php

namespace Modules\Theme\Facades;

use Modules\Theme\ThemeOption;
use Illuminate\Support\Facades\Facade;

/**
 * Class ManagerFacade
 * @package Modules\Base
 */
class ThemeOptionFacade extends Facade
{

    /**
     * @return string
     * @author Tuan Louis
     */
    protected static function getFacadeAccessor()
    {
        return ThemeOption::class;
    }
}
