<?php

namespace Modules\Payment\Facades;

use Modules\Payment\Onepay;
use Illuminate\Support\Facades\Facade;

/**
 * Class ManagerFacade
 * @package Modules\Base
 */
class OnepayFacade extends Facade
{

    /**
     * @return string
     * @author Tuan Louis
     */
    protected static function getFacadeAccessor()
    {
        return Onepay::class;
    }
}
