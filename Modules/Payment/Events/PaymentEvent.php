<?php

namespace Modules\Payment\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class PaymentEvent
{
	use SerializesModels;

	/**
	 * @var string
	 */
	//public $screen;


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
		//$this->request = $request;
		$this->data = $data;
	}

}
