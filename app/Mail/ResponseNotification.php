<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResponseNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $content; // complaint or feedback
    public $responseText; // responce

    public function __construct($content, $responseText)
    {
        $this->content = $content;
        $this->responseText = $responseText;
    }

    public function build()
    {
        return $this->subject('New Response to Your Submission - Injibara University')
                    ->view('emails.response_notification');
    }
}