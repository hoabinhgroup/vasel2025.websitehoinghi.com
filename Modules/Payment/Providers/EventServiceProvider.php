<?php

namespace Modules\Payment\Providers;

use Modules\Payment\Listeners\RegisterOnepayPaymentMethod;

use Modules\Payment\Events\RenderingPaymentMethods;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RenderingPaymentMethods::class => [
            RegisterOnepayPaymentMethod::class,
        ]       
    ];
}
