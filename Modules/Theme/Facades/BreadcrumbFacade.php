<?php

namespace Modules\Theme\Facades;

use Modules\Theme\Breadcrumb;
use Illuminate\Support\Facades\Facade;

/**
 * Class ManagerFacade
 * @package Modules\Base
 */
class BreadcrumbFacade extends Facade
{

    /**
     * @return string
     * @author Tuan Louis
     */
    protected static function getFacadeAccessor()
    {
        return Breadcrumb::class;
    }
}
