<?php

namespace Modules\Payment\Listeners;

use Modules\Payment\Enums\PaymentMethodEnum;
use PaymentMethods;

class RegisterOnepayPaymentMethod
{
    public function handle(): void
    {
        PaymentMethods::method(ONEPAY_PAYMENT_METHOD_NAME, [
            'html' => view('payment::partials.onepay')->render(),
            'priority' => 998,
        ]);

    }
}
