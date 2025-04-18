<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderClosed extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
   
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->user;
        return $this->subject('MeuRH_Subscription '.$data['subscription_code'].' fechada')->view('email.orderClosed');
    }
}
