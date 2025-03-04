<?php
namespace Modules\Payment\Enums;

use Modules\Base\Supports\Enum;
use Html;
use Illuminate\Support\HtmlString;

class PaymentMethodEnum extends Enum
{
    public const BANK_TRANSFER = 'bank-transfer';
    public const CASH = 'cash';
    public const ONEPAY_PAYMENT = 'onepay-payment';
    public const BANK_TRANSFER_FEEDBACK = 'bank-transfer-feedback';
    public const CASH_FEEDBACK = 'cash-feedback';
    public const ONEPAY_PAYMENT_FEEDBACK = 'onepay-payment-feedback';
    public const ONEPAY_PAYMENT_REDIRECT = 'onepay-payment-redirect';

    public static $langPath = 'payment::payment.methods';

    public function getServiceClass(): ?string
    {
        return apply_filters(PAYMENT_FILTER_GET_SERVICE_CLASS, null, $this->value);
    }
}