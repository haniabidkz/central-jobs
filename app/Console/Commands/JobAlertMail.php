<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Candidate\CandidateService;

class JobAlertMail extends Command
{
    protected $candidateService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobalert:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'New Job Alert Mail to Candidate who has Subscribed this Company';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CandidateService $candidateService)
    {
        parent::__construct();
        $this->candidateService = $candidateService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Fetch all save as draft job from cron tbl
        $type = 'job_post_alert';
        $saveAsDraftJobs = $this->candidateService->sendJobAlertMailToCandidate($type);
        //dd($saveAsDraftJobs);
        $this->info('Cron jobs mail send for Reminder Draft Jobs');
    }
}
