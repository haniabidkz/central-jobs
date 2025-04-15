<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\CompanyValidate;
use Mail;

class SendEmailValidateUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $imgPath;
    protected $reason;
    protected $admin;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details,$imgPath,$reason,$admin)
    {
        $this->details = $details;
        $this->imgPath = $imgPath;
        $this->reason = $reason;
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new CompanyValidate($this->details,$this->imgPath,$this->reason,$this->admin);
        Mail::to($this->details['email'])->send($email);
    }
}
