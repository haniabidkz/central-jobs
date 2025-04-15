<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\Candidate\CandidateService;
use Illuminate\Support\Facades\Mail;

class NewJobAlert extends Command
{
    protected $candidateService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newjob:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Job Alerts Email';

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
        //$todaysJob = $this->candidateService->getAllNewJob();
        //Save at cron job master table
        $addToCronJob = $this->candidateService->addToCronJobAlert();

        $this->info('Cron jobs added for New Jobs');
    }
}
