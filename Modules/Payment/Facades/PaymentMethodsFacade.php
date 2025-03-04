<?php

namespace Modules\Payment\Facades;

use Modules\Payment\Services\PaymentMethods;
use Illuminate\Support\Facades\Facade;

class PaymentMethodsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PaymentMethods::class;
    }
}
