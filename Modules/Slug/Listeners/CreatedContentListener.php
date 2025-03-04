<?php

namespace Modules\Slug\Listeners;

use Modules\Base\Events\CreatedContentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Slug\Repositories\SlugInterface;
use Exception;
use Illuminate\Support\Str;

class CreatedContentListener
{
    protected $slug;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SlugInterface $slug)
    {
        $this->slug = $slug;
    }

    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @return void
     */
    public function handle(CreatedContentEvent $event)
    {
        try {
            $this->slug->createSlug(
                $event->request["slug"] ?? Str::slug($event->data->name),
                $event->data->id,
                get_class($event->data)
            );
        } catch (Exception $exception) {
            $exception->getMessage();
        }
    }
}
