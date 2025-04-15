<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $RememberToken;
    public $imgPath;
    public $logoPath;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$RememberToken,$imgPath,$logoPath)
    {
        $this->user          = $user;
        $this->RememberToken = $RememberToken;
        $this->imgPath = $imgPath;
        $this->logoPath = $logoPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.forgotPassword');
    }
}
