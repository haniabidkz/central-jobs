<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlockedUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $imgPath;
    public $admin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$imgPath,$admin)
    {
        $this->user = $user;
        $this->imgPath = $imgPath;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.blockedUser')
                    ->subject('Bloqueado pelo administrador Central Jobs');
    }
}
