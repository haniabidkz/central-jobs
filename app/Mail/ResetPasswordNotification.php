<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $RememberToken;
    public $imgPath;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$RememberToken,$imgPath)
    {
        $this->user          = $user;
        $this->RememberToken = $RememberToken;
        $this->imgPath = $imgPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.forgotPasswordFrontend')
                    ->subject('Central Jobs confidencial - redefinir nova senha');
    }
}
