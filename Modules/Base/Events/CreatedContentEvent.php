<?php

namespace Modules\Base\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class CreatedContentEvent
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
        //$this->screen = $screen;
        $this->request = $request;
        $this->data = $data;
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
