<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationEndpoint50 extends Mailable
{
    use Queueable, SerializesModels;

    private $endpoint;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notification-endpoint-50');
    }
}
