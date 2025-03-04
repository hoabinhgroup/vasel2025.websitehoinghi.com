<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\Action;
use Illuminate\Support\Facades\Facade;

/**
 * Class ActionFacade
 * @package Modules\Base
 */
class ActionFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return Action::class;
    }
}
