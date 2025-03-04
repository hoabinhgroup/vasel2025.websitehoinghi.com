<?php

namespace Modules\Api\Notifications;

use Illuminate\Bus\Queueable;
use Modules\Api\Emails\SendEmailSubmit;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;


class NotifySubmit extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
       // return ['mail'];
       return [TelegramChannel::class, 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    public function toMail($notifiable)
    {
        return (new SendEmailSubmit($this->data))
                    ->to('louis.standbyme@gmail.com', 'Louis')
                   ->bcc('touroperator@hoabinhtourist.com', 'Tour Operator');
    }


    // notify to telegram
    public function toTelegram($notifiable)
    {

         return TelegramMessage::create()
        ->to($notifiable->telegramid)
        ->content($notifiable->notice);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
