<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveApplicationUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $status)
    {
       $this->data = $data;
       $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.leaveApplicationStatus');
    }
}
