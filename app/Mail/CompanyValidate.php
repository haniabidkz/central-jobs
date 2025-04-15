<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyValidate extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $imgPath;
    public $reason;
    public $admin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$imgPath,$reason,$admin)
    {
        $this->user = $user;
        $this->imgPath = $imgPath;
        $this->reason = $reason;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $maildata = $this->view('email.companyValidate');
        if($this->user['profile']['approve_status'] == 1){
            $maildata =  $maildata->subject('Confirmação de validação pelo administrador!');
        }else{
             $maildata =  $maildata->subject('Rejeição de validação por Admin!');
        }
        return $maildata;
    }
}
