<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Candidate\CandidateService;
use Illuminate\Support\Facades\Mail;

class ChangeJobStatus extends Command
{
    protected $candidateService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:jobstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Job Status';

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
        //Fetch all pending and ongoing jobs and update status to onging and closed.
        $saveAsDraftJobs = $this->candidateService->changeJobStatus();
        $this->info('Cron jobs to change status of post jobs');
    }
}
