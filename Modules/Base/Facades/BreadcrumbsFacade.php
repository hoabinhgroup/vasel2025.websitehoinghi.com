<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\BreadcrumbsManager;
use Illuminate\Support\Facades\Facade;

class BreadcrumbsFacade extends Facade
{
    /**
     * Get the name of the class registered in the Application container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BreadcrumbsManager::class;
    }
}
