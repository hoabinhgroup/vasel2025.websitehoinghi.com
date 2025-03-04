<?php

namespace Modules\Member\Providers;

use Modules\Registration\Events\RegistrationSubmitEvent;
use Modules\Member\Listeners\MemberRegistrationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
	RegistrationSubmitEvent::class => [MemberRegistrationListener::class]
  ];
}
