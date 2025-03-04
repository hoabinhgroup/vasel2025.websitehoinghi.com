<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\Slim;
use Illuminate\Support\Facades\Facade;

class SlimFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author Tuan Louis
     */
    protected static function getFacadeAccessor()
    {
        return Slim::class;
    }
}
