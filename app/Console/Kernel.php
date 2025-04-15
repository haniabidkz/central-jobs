<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ReminderOfDraftJob::class,
        Commands\SendReminderMail::class,
        Commands\DeleteLoginHistory::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $to_name = 'Rumpa Ghosh';
        // $to_email = 'rumpa12tgb@gmail.com';
        // $data = [];

        // Mail::send('email/mail', $data, function($message) use ($to_name, $to_email) {
        //     $message->to($to_email, $to_name)
        //     ->subject('Laravel Test Mail Cron Job');
        //     $message->from('rumpa.g.unified@gmail.com','Test mail schedular');
        // });
        //Draft Job Reminder Start
        $schedule->command('reminder:draftjob')
        ->dailyAt('00:05');
        //->timezone('Asia/Kolkata');	

        $schedule->command('remindermail:draftjob')
        ->dailyAt('00:10');
        //->timezone('Asia/Kolkata');	
         //Draft Job Reminder End

        //New Job Alert Start
        $schedule->command('newjob:alert')
        ->dailyAt('00:05');
        //->timezone('Asia/Kolkata');	

        $schedule->command('jobalert:mail')
        ->dailyAt('00:10');
        //->timezone('Asia/Kolkata');	
        //New Job Alert End

        //Job Status Change
        $schedule->command('change:jobstatus')
        ->dailyAt('00:05')
        ->sendOutputTo('jobStatus.log');
        //->timezone('Asia/Kolkata');	
        //Job Status Change

        //Delete Login History for over 10 weeks
        $schedule->command('deleteHistory:cron')
        ->dailyAt('00:05');
        //->timezone('Asia/Kolkata');	
        //Delete login history

        //Delete Closed Applied Jobs for one day after
        $schedule->command('deleteclosedappliedjobs:cron')
        ->dailyAt('00:05');
        //->timezone('Asia/Kolkata');	
        //Delete Closed Applied Jobs



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
