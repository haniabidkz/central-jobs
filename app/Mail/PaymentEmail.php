<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentEmail extends Mailable
{
    use Queueable, SerializesModels;
     /**
     * The order instance.
     *
     * @var Transaction
     */
    public $transactionInfo;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transactionInfo,$user)
    {
        $this->transactionInfo  = $transactionInfo;
        $this->user             = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $transactionInfo = $this->transactionInfo;
        if($user->user_type==3)
        {
            return $this->subject('MeuRH_Payment  Link de pagamento')->view('email_english.payment_company',compact('user','transactionInfo'));
        }else{
            return $this->subject('MeuRH_Subscription '.$user['subscription_id'].' Link de pagamento')->view('email_english.payment',compact('user','transactionInfo'));
        }
        
    }
}
