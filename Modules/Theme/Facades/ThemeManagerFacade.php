<?php

namespace Modules\Theme\Facades;

use Modules\Theme\ThemeManager;
use Illuminate\Support\Facades\Facade;

/**
 * Class ManagerFacade
 * @package Modules\Base
 */
class ThemeManagerFacade extends Facade
{

    /**
     * @return string
     * @author Tuan Louis
     */
    protected static function getFacadeAccessor()
    {
        return ThemeManager::class;
    }
}
