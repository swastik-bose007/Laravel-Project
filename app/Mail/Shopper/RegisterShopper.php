<?php

namespace App\Mail\Shopper;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterShopper extends Mailable {

    use Queueable,
        SerializesModels;

    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('shopper.emails.welcome')
        ->with([
            "name" => $this->name
        ]);
    }

}
