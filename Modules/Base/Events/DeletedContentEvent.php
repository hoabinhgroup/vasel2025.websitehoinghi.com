<?php

namespace Modules\Base\Events;

use Illuminate\Queue\SerializesModels;

class DeletedContentEvent
{
    use SerializesModels;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Eloquent|false
     */
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request, $data, $action = false)
    {
        $this->request = $request;
        $this->data = $data;
        $this->action = $action;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    // public function broadcastOn()
    // {
    //     return [];
    // }
}
