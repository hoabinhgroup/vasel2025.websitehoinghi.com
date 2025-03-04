<?php
namespace Modules\Registration\Entities\Observers;

use Modules\Member\Entities\MemberRegistration;
use Modules\Registration\Entities\Invited;
use Modules\Registration\Traits\Attendance;
use Theme;

class InvitedObserver
{
	use Attendance;

	public function creating(Invited $registration)
	{
		$registration->email = getMemberSignedIn()->email;
		$registration->title = request()->titleOther ?? request()->title;
		$registration->dietary = request()->dietaryOther ?? request()->dietary;
	}
	
	
	/**
	 * Handle the post "created" event.
	 *
	 * @param  \App\Post  $post
	 * @return void
	 */
	public function created(Invited $registration)
	{
		//update guest code
		$registration->guest_code = $this->getCode($registration);
		$registration->save();
		
	}

	
}