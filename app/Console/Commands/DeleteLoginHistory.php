<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\UserLoginHistoryService;

class DeleteLoginHistory extends Command
{
    protected $userLoginHistory;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteHistory:cron';

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
    public function __construct(UserLoginHistoryService $userLoginHistory)
    {
        parent::__construct();
        $this->userLoginHistory = $userLoginHistory;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Fetch all save as draft job from cron tbl
        $saveAsDraftJobs = $this->userLoginHistory->deleteLoginHistory();
        //dd($saveAsDraftJobs);
        $this->info('Cron jobs for deleteing login history');
    }
}
