<?php

namespace App\Mail\Shopper;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable {

    use Queueable,
        SerializesModels;

        public $userData;
        public $token;
        public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData, $token, $name) {
        $this->userData = $userData;
        $this->token = $token;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                ->view('shopper.emails.forgot-password')
                ->with([
                    "userData" => $this->userData,
                    "token" => $this->token,
                    "name" => $this->name
                ]);
    }

}
