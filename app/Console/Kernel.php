<?php

namespace App\Console;

use App\Jobs\AttendanceJob;
use App\Models\Attendance;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the AttendanceJob to run daily at midnight
       $schedule->job(new AttendanceJob())->dailyAt('00:00');
        //$schedule->job(new AttendanceJob())->everyMinute();


    }

 /*   protected function schedule(Schedule $schedule)
    {
        $schedule->job(new AttendanceJob())->cron('0 12 * * *'); // Runs at 12:00 PM for testing
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
