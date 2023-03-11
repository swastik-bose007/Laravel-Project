<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceivedNotification extends Mailable {

    use Queueable,
        SerializesModels;

    public $heading;
    public $message;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($heading,$message) {
        $this->heading    = $heading;
        $this->message    = $message;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('admin.emails.notification')
        ->with([
            "heading"   => $this->heading,
            "msg"       => $this->message
        ]);
    }

}
