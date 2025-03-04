<?php

namespace Modules\Seo\Listeners;

use Modules\Base\Events\CreatedContentEvent;
use Exception;
use SeoHelper;

class CreatedContentListener
{
    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @return void
     */
    public function handle(CreatedContentEvent $event)
    {
        try {
            SeoHelper::saveMetaData($event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
