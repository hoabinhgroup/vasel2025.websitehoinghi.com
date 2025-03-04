<?php

namespace Modules\Member\Listeners;

use Modules\Registration\Events\RegistrationSubmitEvent;
use Modules\Member\Entities\MemberRegistration;
use Exception;
use Log;

class MemberRegistrationListener
{
  /**
   * Handle the event.
   *
   * @param CreatedContentEvent $event
   * @return void
   */
  public function handle(RegistrationSubmitEvent $event)
  {
	try {
	 $this->updateRegistrationMember($event->data);
	} catch (Exception $exception) {
	  Log::info($exception->getMessage());
	}
  }
  
  
  protected function updateRegistrationMember($registration)
	{
	  if(checkMemberSignedIn()){
	   $memberRegistration = new MemberRegistration;
	   $memberRegistration->member_id = getMemberSignedIn()->id;
	   $memberRegistration->reference_id = $registration->id;
	   $memberRegistration->reference_type = get_class($registration);
	   $memberRegistration->save();
	   }
	   return true;
	}
}
