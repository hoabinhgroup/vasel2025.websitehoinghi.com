<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateAttendanceStatus implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;
	
	public $message;
	
	public function __construct($message)
	{
		$this->message = $message;
	}
	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		\Log::debug("Attendance: 123");
		return new Channel('attendance-status');
	}
}
