<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\PanelMenu;
use Illuminate\Support\Facades\Facade;

class PanelMenuFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PanelMenu::class;
    }
}
