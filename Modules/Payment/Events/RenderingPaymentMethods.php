<?php

namespace Modules\Payment\Events;

class RenderingPaymentMethods
{
    public function __construct($methods)
    {
        return $methods;
    }
}
