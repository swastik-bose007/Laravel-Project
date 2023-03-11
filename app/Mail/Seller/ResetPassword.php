<?php

namespace App\Mail\Seller;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable {

    use Queueable,
        SerializesModels;

        public $userData;
        public $token;
        

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData, $token) {
        $this->userData = $userData;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                ->view('seller.emails.forgot-password')
                ->with([
                    "userData" => $this->userData,
                    "token" => $this->token
                ]);
    }

}
