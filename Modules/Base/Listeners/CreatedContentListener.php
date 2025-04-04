<?php

namespace Modules\Base\Listeners;

use Modules\Base\Events\CreatedContentEvent;
use Exception;

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
      do_action(
        BASE_ACTION_AFTER_CREATE_CONTENT,
        $event->request,
        $event->data
      );
    } catch (Exception $exception) {
      info($exception->getMessage());
    }
  }
}
