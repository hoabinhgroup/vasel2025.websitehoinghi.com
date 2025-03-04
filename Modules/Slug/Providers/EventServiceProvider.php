<?php

namespace Modules\Slug\Providers;

use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Slug\Listeners\CreatedContentListener;
use Modules\Slug\Listeners\UpdatedContentListener;
use Modules\Slug\Listeners\DeletedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	
   protected $listen = [
        CreatedContentEvent::class => [
            	CreatedContentListener::class,
        ],
        UpdatedContentEvent::class => [
            	UpdatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            	DeletedContentListener::class,
        ]
    ];
}
