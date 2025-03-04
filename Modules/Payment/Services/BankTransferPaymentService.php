<?php 
namespace Modules\Payment\Services;

use Modules\Payment\Enums\PaymentMethodEnum;
use Illuminate\Support\Str;

class BankTransferPaymentService
{
    public function execute($data)
    {
        $chargeId = Str::upper(Str::random(10));

        do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, $data);

        $data->setAttribute(PaymentMethodEnum::BANK_TRANSFER_FEEDBACK, $data);
        return $chargeId;
    }
}
