<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
// use Modules\Emailmarketing\Entities\EmailCampaigns;
// use Modules\Emailmarketing\Entities\EmailAutomations;
// use Modules\Emailmarketing\Repositories\EmailcampaignsInterface;
// use Modules\Emailmarketing\Repositories\EmailAutomationsInterface;
// use Modules\Emailmarketing\Events\HandleJobProcessedEvent;
// use Modules\Emailmarketing\Events\HandleJobProcessingEvent;
use App\Models\PhotoboothCheckIn;
use App\Models\Attendances;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use function Psy\debug;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Schema::defaultStringLength(191);
    \URL::forceScheme('https');
    //   Validator::extend('unique_photobooth_entry', function ($attribute, $value, $parameters, $validator) {

    //     $customer_code = 0;
    //     if($attribute == 'customer_code'){
    //       $customer_code = $value;
    //     }
    //     $photoboothId = $parameters[0];


    //     // Kiểm tra xem đã tồn tại mã khách hàng này trong photobooth này chưa
    //     $existingEntry = PhotoboothCheckIn::where('customer_code', $customer_code)
    //         ->where('photobooth_id', $photoboothId)
    //         ->exists();

    //    return !$existingEntry;
    // });


    // Validator::extend('loggedCheckin', function ($attribute, $value, $parameters, $validator) {
    //     $customer_code = 0;
    //     if($attribute == 'customer_code'){
    //       $customer_code = $value;
    //     }

    //     // Kiểm tra trạng thái đăng nhập
    //     $existingEntry = Attendances::where('id', $customer_code)
    //         ->where('status', 1)
    //         ->exists();

    //    return $existingEntry;
    // });

    //
    // $manager = app(QueueManager::class);

    // $manager->before(static function (JobProcessing $event) {
    //   $job = $event->job;
    //   $payload = json_decode($job->getRawBody());
    //   $data_type = $payload->displayName;
    //   $data = (array) unserialize($payload->data->command);

    //   if ($data_type == "Modules\\Emailmarketing\\Jobs\\SendMailMarketing") {
    //     $id = $data["\0*\0options"]["id"];
    //     EmailCampaigns::where("id", $id)->increment("mail_sent", 1);
    //     app()
    //       ->make(EmailcampaignsInterface::class)
    //       ->update($id, ["status" => "sending"]);
    //     // app()->make(EmailcampaignsInterface::class)->update($id, ['error' => $job->getRawBody()]);
    //     // app()->make(EmailcampaignsInterface::class)->update($id, ['status' => 'sending']);
    //   } elseif (
    //     $data_type == "Modules\\Emailmarketing\\Jobs\\SendMailAutomation"
    //   ) {
    //     $id = $data["\0*\0options"]["id"];
    //     EmailAutomations::where("id", $id)->increment("mail_sent", 1);
    //     app()
    //       ->make(EmailAutomationsInterface::class)
    //       ->update($id, ["run_at" => Carbon::now()->toDateTimeString()]);
    //   }
    // });

    // $manager->after(static function (JobProcessed $event) {
    //   // QueueMonitor::handleJobProcessed($event);
    //   // event(new HandleJobProcessedEvent($event));
    //   // app()->make(EmailcampaignsInterface::class)->update(1, ['status' => 'sent']);

    //   $job = $event->job;
    //   $payload = json_decode($job->getRawBody());
    //   $data_type = $payload->displayName;
    //   $data = (array) unserialize($payload->data->command);
    //   if ($data_type == "Modules\\Emailmarketing\\Jobs\\SendMailMarketing") {
    //     $id = $data["\0*\0options"]["id"];

    //     app()
    //       ->make(EmailcampaignsInterface::class)
    //       ->update($id, ["status" => "sent"]);
    //     // app()->make(EmailcampaignsInterface::class)->update($id, ['error' => $job->getRawBody()]);
    //     // app()->make(EmailcampaignsInterface::class)->update($id, ['status' => 'sending']);
    //   } elseif (
    //     $data_type == "Modules\\Emailmarketing\\Jobs\\SendMailAutomation"
    //   ) {
    //     $id = $data["\0*\0options"]["id"];
    //     app()
    //       ->make(EmailAutomationsInterface::class)
    //       ->update($id, [
    //         "finished_at" => Carbon::now()->toDateTimeString(),
    //         "payload" => $payload->data->command,
    //       ]);
    //   }
    // });

    // $manager->failing(static function (JobFailed $event) {
    //   //   QueueMonitor::handleJobFailed($event);
    //   $job = $event->job;
    //   $payload = json_decode($job->getRawBody());
    //   $data_type = $payload->displayName;
    //   $data = (array) unserialize($payload->data->command);

    //   if ($data_type == "Modules\\Emailmarketing\\Jobs\\SendMailMarketing") {
    //     $id = $data["\0*\0options"]["id"];

    //     app()
    //       ->make(EmailcampaignsInterface::class)
    //       ->update($id, ["error" => "Co loi"]);
    //   } elseif (
    //     $data_type == "Modules\\Emailmarketing\\Jobs\\SendMailAutomation"
    //   ) {
    //     $id = $data["\0*\0options"]["id"];
    //     app()
    //       ->make(EmailAutomationsInterface::class)
    //       ->update($id, ["error" => "Co loi"]);
    //   }
    // });
  }
}
