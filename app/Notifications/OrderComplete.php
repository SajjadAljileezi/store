<?php

namespace App\Notifications;

 use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
 use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderComplete extends Notification
{
     use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */


    public function __construct()
    {
            //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data'=> 'Order Has Been Placed'
        ];
    }
}
