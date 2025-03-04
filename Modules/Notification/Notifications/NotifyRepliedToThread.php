<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class NotifyRepliedToThread extends Notification
{
    use Queueable;
    
    public $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

   
    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return database
     */
    public function toDatabase($notifiable)
    {
		$post = app(\Modules\Post\Repositories\PostInterface::class)->find($this->comment->reference_id);
	    $this->comment->thread_name = $post->name;
	    $this->comment->thread_url = $post->slug;
	    	

        return [
            'thread' => $this->comment,
            'user' => auth()->user()
        ];
    }
    
    
     public function toBroadcast($notifiable)
    {
	    $post = app(\Modules\Post\Repositories\PostInterface::class)->find($this->comment->reference_id);
	    $this->comment->thread_name = $post->name;
	    $this->comment->thread_url = $post->slug;

        return new BroadcastMessage([
            'thread' => $this->comment,
            'user' => auth()->user()
        ]);

    }
}
