<?php

namespace Modules\Registration\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class AttachEvent
{
	use SerializesModels;

	/**
	 * @var string
	 */
	//public $screen;

	/**
	 * @var Request
	 */
	public $request;

	/**
	 * @var \Eloquent|false
	 */
	public $data;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($request, $data)
	{
		$this->request = $request;
		$this->data = $data;
	}
}
