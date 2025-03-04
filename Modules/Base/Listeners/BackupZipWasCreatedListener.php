<?php
namespace Modules\Base\Listeners;

use Spatie\Backup\Events\BackupZipWasCreated;

class BackupZipWasCreatedListener
{
  public function handle(BackupZipWasCreated $event)
  {
    //dd($event->pathToZip);
    // print_r($event->pathToZip);
    // if (setting("enable_send_error_reporting_via_telegram", true)) {
    //   $user = new \App\User();
    //   $user->telegramid = \Config::get("services.telegram_id");
    //   $user->notice = "Backup Ziped:" . $event->pathToZip . "\n";
    //   $user->notify(new \Modules\Base\Notifications\NotifyLogs());
    // }
  }
}
