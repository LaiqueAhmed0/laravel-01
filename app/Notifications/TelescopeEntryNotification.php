<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Telescope\IncomingEntry;

class TelescopeEntryNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected IncomingEntry $entry,
        protected string $url,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Telescope Monitoring ({$this->entry->type})")
            ->line('There was a monitored event in your application with type "'.$this->entry->type.'".')
            ->action('Check Details', url($this->url));
    }
}
