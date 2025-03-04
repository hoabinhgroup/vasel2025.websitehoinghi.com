<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\Filter;
use Illuminate\Support\Facades\Facade;

/**
 * Class FilterFacade
 * @package Modules\Base
 */
class FilterFacade extends Facade
{

    /**
     * @return string
     * @author Tuan Louis
     * @since 2.1
     */
    protected static function getFacadeAccessor()
    {
        return Filter::class;
    }
}
