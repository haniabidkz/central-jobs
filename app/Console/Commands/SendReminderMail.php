<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Candidate\CandidateService;

class SendReminderMail extends Command
{
    protected $candidateService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remindermail:draftjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder Mail on Saved as Draft Jobs to Candidate';

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
        $type = 'reminder_save_as_draft_job';
        $saveAsDraftJobs = $this->candidateService->sendMailToCandidate($type);
        //dd($saveAsDraftJobs);
        $this->info('Cron jobs mail send for Reminder Draft Jobs');
    }
}
