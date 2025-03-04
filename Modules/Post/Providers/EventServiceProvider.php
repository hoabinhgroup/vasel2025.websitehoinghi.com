<?php

namespace Modules\Post\Providers;

use Modules\Theme\Events\RenderingSiteMapEvent;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Post\Listeners\RenderingSiteMapListener;
use Modules\Post\Listeners\PostNotificationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    RenderingSiteMapEvent::class => [RenderingSiteMapListener::class],
    CreatedContentEvent::class => [PostNotificationListener::class],
  ];
}
