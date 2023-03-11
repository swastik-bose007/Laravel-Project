<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YourNewPassword extends Mailable {

    use Queueable,
        SerializesModels;

    public $name;
    public $email;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email,$password) {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('admin.emails.send-password')
        ->with([
            "name"             => $this->name,
            "email"            => $this->email,    
            "default-password" => $this->password   
        ]);
    }

}
