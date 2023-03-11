<?php

namespace App\Mail\Shopper;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable {

    use Queueable,
        SerializesModels;

    public $name;
    public $userId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $userId) {
        $this->name = $name;
        $this->userId = $userId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(env('MAIL_FROM_ADDRESS'))->view('shopper.emails.verify-email')->with([
            "name" => $this->name,
            "user_id" => $this->userId
        ]);
    }

}
