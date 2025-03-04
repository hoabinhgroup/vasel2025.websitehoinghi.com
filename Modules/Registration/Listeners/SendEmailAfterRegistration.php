<?php

namespace Modules\Registration\Listeners;

use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Base\Traits\ParseContent;
use Modules\Registration\Traits\SendRegistrationEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailAfterRegistration
{
  use ParseContent, SendRegistrationEmail;

  public function handle($data): void
  {


    // ray(request()->all());
    $params = $data->data->toArray();

    $params = array_merge($params, [
      'subject' => $data->data->subject,
      'registration_channel' => $data->data->registration_channel,
    ]);


    // echo '<pre>';
    // print_r($params);
    // echo '</pre>';
    // die();
    // $params['conference_type'] = $data->data->conference_type;
    // $params['subject'] = $data->data->subject;
    // $params['total'] = $data->data->totalFormatted;
    // if ($data->data->registration_channel == PaymentMethodEnum::ONEPAY_PAYMENT) {
    //   $params['total'] = $data->data->totalTaxFormatted;
    // }


    // render template
    if (setting($data->data->registration_channel)) {
      $template = $this->parseContent(setting($data->data->registration_channel), $params);
    }

    if (app()->isLocal()) {
      sendEmail('louis.standbyme@gmail.com', $params['subject'], $template);
      //  Mail::send([], [], function ($message) use ($params,$template) {
      //   $message->to($params['email'])
      //           ->subject('Registration Confirmation')
      //           ->from('noreply@yourdomain.com', 'APSCVIR2025')
      //           ->setBody($template, 'text/html'); 
      //   });
    } else {
      // gửi email theo template
      $this->sending($params, $template);
    }
  }
}
