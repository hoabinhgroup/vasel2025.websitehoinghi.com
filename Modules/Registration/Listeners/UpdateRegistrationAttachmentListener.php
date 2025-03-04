<?php
namespace Modules\Registration\Listeners;

use Modules\Registration\Events\RegistrationSubmitEvent;
use Modules\Registration\Entities\Registration;
use Illuminate\Support\Facades\Request;
use Exception;
use Illuminate\Support\Arr;
use Log;
use Modules\Registration\Events\AttachEvent;

class UpdateRegistrationAttachmentListener
{

  /**
   * Handle the event.
   *
   * @param CreatedContentEvent $event
   * @return void
   */
  public function handle(AttachEvent $event)
  {

    if (Arr::get($event->request, 'report_file_summary')) {
      try {
        $this->uploadReportFileSummary($event->request, $event->data);
      } catch (Exception $exception) {
        Log::info($exception->getMessage());
      }
    }

    if (Arr::get($event->request, 'report_file_full')) {

      try {
        $this->uploadReportFileFull($event->request, $event->data);
      } catch (Exception $exception) {
        Log::info($exception->getMessage());
      }
    }


    if (Arr::get($event->request, 'shortCV')) {

      try {
        $this->uploadShortCV($event->request, $event->data);
      } catch (Exception $exception) {
        Log::info($exception->getMessage());
      }
    }


    if (Arr::get($event->request, 'passport')) {

      try {
        $this->uploadPassport($event->request, $event->data);
      } catch (Exception $exception) {
        Log::info($exception->getMessage());
      }
    }

    if (Arr::get($event->request, 'unc_statement')) {

      try {
        $this->uploadUncStatement($event->request, $event->data);
      } catch (Exception $exception) {
        Log::info($exception->getMessage());
      }
    }

  }

  protected function uploadReportFileSummary($request, $registration)
  {

    $registration->report_file_summary = $request['report_file_summary']->store($registration->urlReportFileSummary($registration), setting('media_driver', 'public'));
    $registration->save();
  }

  protected function uploadReportFileFull($request, $registration)
  {

    $registration->report_file_full = $request['report_file_full']->store($registration->urlReportFileFull($registration), setting('media_driver', 'public'));
    $registration->save();
  }

  protected function uploadShortCV($request, $registration)
  {
    $registration->shortCV = $request['shortCV']->store($registration->urlShortCV($registration), setting('media_driver', 'public'));
    $registration->save();
  }

  protected function uploadPassport($request, $registration)
  {
    $registration->passport = $request['passport']->store($registration->urlPassport($registration), setting('media_driver', 'public'));
    $registration->save();
  }

  protected function uploadUncStatement($request, $registration)
  {
    $registration->unc_statement = $request['unc_statement']->store($registration->urlUncStatement($registration), setting('media_driver', 'public'));
    $registration->save();
  }




}
