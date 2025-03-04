<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class NotifyContact extends Notification
{
  use Queueable;

  public $contact;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($contact)
  {
    $this->contact = $contact;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param mixed $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ["database", "broadcast"];
  }

  /**
   * Get the array representation of the notification.
   *
   * @param mixed $notifiable
   * @return database
   */
  public function toDatabase($notifiable)
  {
    $contact = app(\Modules\Contact\Repositories\ContactInterface::class)->find(
      $this->contact->id
    );
    $this->contact->thread_name = $contact->title;
    $this->contact->thread_url = $contact->message;

    return [
      "thread" => $this->contact,
      "user" => auth()->user(),
    ];
  }

  public function toBroadcast($notifiable)
  {
    $contact = app(\Modules\Contact\Repositories\ContactInterface::class)->find(
      $this->contact->id
    );
    $this->contact->thread_name = $contact->title;
    $this->contact->thread_url = $contact->message;

    return new BroadcastMessage([
      "thread" => $this->contact,
      "user" => auth()->user(),
    ]);
  }
}
