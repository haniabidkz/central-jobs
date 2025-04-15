<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConnectionRequestNotification extends Mailable
{
    use Queueable, SerializesModels;
     /**
     * The order instance.
     *
     * @var Order
     */
    public $userData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData)
    {   
        $this->userData = $userData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->subject('MeuRH_Pedido de conexão_'.$this->userData['from_first_name'].' '.$this->userData['from_last_name'])->view('email.connectionReqNotification');
    }
}
