<?php

namespace Modules\Registration\Providers;

use Modules\Registration\Events\RegistrationSubmitEvent;
use Modules\Registration\Listeners\UpdateRegistrationAttachmentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Payment\Events\PaymentEvent;
use Modules\Registration\Events\AttachEvent;
use Modules\Registration\Listeners\UpdateMemberListener;
use Modules\Registration\Events\NotificationAfterSubmit;
use Modules\Registration\Listeners\PaymentAfterRegistration;
use Modules\Registration\Listeners\SendEmailAfterRegistration;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    RegistrationSubmitEvent::class => [
      PaymentAfterRegistration::class
      // UpdateMemberListener::class
    ],
    AttachEvent::class => [
      UpdateRegistrationAttachmentListener::class
    ],
    PaymentEvent::class => [
      PaymentAfterRegistration::class
    ],
    NotificationAfterSubmit::class => [
      SendEmailAfterRegistration::class
    ]
  ];
}
