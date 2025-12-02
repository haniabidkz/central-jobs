<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

// Migrated schedules from legacy App\Console\Kernel
Schedule::command('reminder:draftjob')->dailyAt('00:05');
Schedule::command('remindermail:draftjob')->dailyAt('00:10');

Schedule::command('newjob:alert')->dailyAt('00:05');
Schedule::command('jobalert:mail')->dailyAt('00:10');

Schedule::command('change:jobstatus')
    ->dailyAt('00:05')
    ->sendOutputTo('jobStatus.log');

Schedule::command('deleteHistory:cron')->dailyAt('00:05');
Schedule::command('deleteclosedappliedjobs:cron')->dailyAt('00:05');
