<?php

namespace Modules\Payment\Services;

use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Payment\Enums\PaymentStatusEnum;
use Modules\Payment\Enums\PaymentStatusVnEnum;
use Modules\Registration\Enums\PaymentStatusEnums;
use Illuminate\Support\Str;
use Modules\Payment\Libraries\Onepay;

class OnepayPaymentService
{
    public function execute($data)
    {

        $chargeId = Str::upper(Str::random(10));

        do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, $data);

        $this->handleBeforePaymentPageRedirect($data);

        return $chargeId;
    }

    protected function payment($registration)
    {

        $accountant = $registration->is_international ? 'international' : 'international_vnd';
        ray('payment', $accountant);
        $onepay = new Onepay($accountant);

        return $onepay;
    }

    protected function paymentByMerchant($param)
    {
        $vpcMerchantConfig = config('payment.info.international.vpc_Merchant');

        $accountant = $param['vpc_Merchant'] == $vpcMerchantConfig ? 'international' : 'international_vnd';
        ray('paymentByMerchant', $accountant);
        $onepay = new Onepay($accountant);

        return $onepay;
    }

    protected function handleBeforePaymentPageRedirect($registration)
    {
        ray('handleBeforePaymentPageRedirect', $registration);
        $onepay = $this->payment($registration);

        $total = $registration->total;

        ray('$this->getAmount($total)', $this->getAmount($total));

        $url = $onepay->buildPaymentLink(
            $registration->guest_code,
            $registration->guest_code . '_' . time(),
            $this->getAmount($total),
            route('payment.registration.dr')
        );

        return $registration->setAttribute(PaymentMethodEnum::ONEPAY_PAYMENT_REDIRECT, $url);
    }

    protected function getAmount($amount)
    {
        return $amount + ($amount * 0.05);
    }

    public function handleResponse($params)
    {

        $onepay = $this->paymentByMerchant($params);

        $responseCode = $onepay->getResponseCode($params);

        $payloadResponse = $this->getPayloadResponse($responseCode);

        return $payloadResponse;
    }


    protected function getPayloadResponse($responseCode)
    {
        $response = [];
        if ($responseCode === 0) {
            $response['status'] = PaymentStatusEnums::SUCCESSFUL;
            $response['statusen'] = PaymentStatusEnum::COMPLETED;
            $response['statusvn'] = PaymentStatusVnEnum::COMPLETED;
            $response[PaymentMethodEnum::ONEPAY_PAYMENT_FEEDBACK] = 'registration.successful';
        } elseif ($responseCode == '99') {
            $response['status'] = PaymentStatusEnums::CANCELLED;
            $response['statusen'] = PaymentStatusEnum::CANCELLED;
            $response['statusvn'] = PaymentStatusVnEnum::CANCELLED;
            $response[PaymentMethodEnum::ONEPAY_PAYMENT_FEEDBACK] = 'registration.cancel';
        } else {
            $response['status'] = PaymentStatusEnums::FAILED;
            $response['statusen'] = PaymentStatusEnum::FAILED;
            $response['statusvn'] = PaymentStatusVnEnum::FAILED;
            $response[PaymentMethodEnum::ONEPAY_PAYMENT_FEEDBACK] = 'registration.error';
        }
        return $response;
    }
}
