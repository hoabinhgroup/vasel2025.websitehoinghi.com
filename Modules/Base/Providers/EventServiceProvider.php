<?php

namespace Modules\Base\Providers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Listeners\BeforeEditContentListener;
use Modules\Base\Listeners\CreatedContentListener;
use Modules\Base\Listeners\UpdatedContentListener;
use Spatie\Backup\Events\BackupZipWasCreated;
use Modules\Base\Listeners\BackupZipWasCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    BeforeEditContentEvent::class => [BeforeEditContentListener::class],
    UpdatedContentEvent::class => [UpdatedContentListener::class],
    CreatedContentEvent::class => [CreatedContentListener::class],
    BackupZipWasCreated::class => [BackupZipWasCreatedListener::class],
  ];
}
