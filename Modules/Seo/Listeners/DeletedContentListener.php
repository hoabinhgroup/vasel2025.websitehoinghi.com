<?php

namespace Modules\Seo\Listeners;

use Modules\Base\Events\DeletedContentEvent;
use Exception;
use SeoHelper;

class DeletedContentListener
{

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     */
    public function handle(DeletedContentEvent $event)
    {
        try {
            SeoHelper::deleteMetaData($event->data, $event->action);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
