<?php

namespace Modules\Base\Listeners;

use Modules\Base\Events\UpdatedContentEvent;
use Exception;

class UpdatedContentListener
{
  /**
   * Handle the event.
   *
   * @param UpdatedContentEvent $event
   * @return void
   */
  public function handle(UpdatedContentEvent $event)
  {
    try {
      do_action(
        BASE_ACTION_AFTER_UPDATE_CONTENT,
        $event->request,
        $event->data
      );
    } catch (Exception $exception) {
      info($exception->getMessage());
    }
  }
}
