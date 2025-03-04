<?php

namespace Modules\Registration\Listeners;

use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Payment\Services\BankTransferPaymentService;
use Modules\Payment\Services\OnepayPaymentService;
use PaymentMethods;
use Illuminate\Support\Arr;

class PaymentAfterRegistration
{
  public function handle($data)
  {

    // xử lý event payment sau khi đăng ký
    switch ($data->data->payment_method) {
      case PaymentMethodEnum::ONEPAY_PAYMENT:

        $data->charge_id = app(OnepayPaymentService::class)->execute($data->data);
        break;

      case PaymentMethodEnum::BANK_TRANSFER:
        $data->charge_id = app(BankTransferPaymentService::class)->execute($data->data);
        break;
      case PaymentMethodEnum::CASH:
        $data->charge_id = app(CashPaymentService::class)->execute($data->data);
        break;
      default:
        $data = apply_filters(PAYMENT_FILTER_AFTER_POST_CHECKOUT, $data, request()->all());

        break;
    }

    return $data;
  }
}
