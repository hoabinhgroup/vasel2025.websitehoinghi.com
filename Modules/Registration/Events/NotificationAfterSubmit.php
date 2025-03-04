<?php

namespace Modules\Registration\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class NotificationAfterSubmit
{
	use SerializesModels;

	/**
	 * @var \Eloquent|false
	 */
	public $data;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

}
