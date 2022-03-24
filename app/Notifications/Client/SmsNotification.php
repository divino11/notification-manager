<?php

namespace App\Notifications\Client;

use App\Models\Notification as NotificationEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public NotificationEvent $notification
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['vonage'];
    }

    /**
     * Get the sms representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return VonageMessage
     */
    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content($this->notification->content);
    }
}
