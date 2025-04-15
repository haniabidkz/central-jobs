<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Candidate\CandidateService;
use Illuminate\Support\Facades\Mail;

class ReminderOfDraftJob extends Command
{
    protected $candidateService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:draftjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add to Cron Master Table for Reminder Mail on Saved as Draft Jobs to Candidate';

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
        //Fetch all save as draft job
        $saveAsDraftJobs = $this->candidateService->getAllDraftJob();
        
        //Save at cron job master table
        $addToCronJob = $this->candidateService->addToCronJob($saveAsDraftJobs);
         $this->info('Cron jobs added for Reminder Draft Jobs');
    }
}
