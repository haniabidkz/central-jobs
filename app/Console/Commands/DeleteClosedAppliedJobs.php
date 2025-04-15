<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\JobService;

class DeleteClosedAppliedJobs extends Command
{
    protected $jobService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteclosedappliedjobs:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(JobService $jobService)
    {
        parent::__construct();
        $this->jobService = $jobService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Fetch all save as draft job from cron tbl
        $saveAsDraftJobs = $this->jobService->deleteClosedAppliedJobs();
        //dd($saveAsDraftJobs);
        $this->info('Cron jobs for deleteing closed applied jobs');
    }
}
