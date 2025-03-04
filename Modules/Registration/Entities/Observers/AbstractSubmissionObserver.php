<?php
namespace Modules\Registration\Entities\Observers;

use Modules\Member\Entities\MemberRegistration;
use Modules\Registration\Entities\AbstractSubmission;

class AbstractSubmissionObserver
{
	
	public function creating(AbstractSubmission $post)
	{
		
	}
	/**
	 * Handle the post "created" event.
	 *
	 * @param  \App\Post  $post
	 * @return void
	 */
	public function created(AbstractSubmission $post)
	{
		
	}

}