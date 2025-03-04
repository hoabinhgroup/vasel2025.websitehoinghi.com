<?php

namespace Modules\Menu\Facades;

use Modules\Menu\Menu;
use Illuminate\Support\Facades\Facade;

class MenuFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author Tuan Louis
     */
    protected static function getFacadeAccessor()
    {
        return Menu::class;
    }
}
