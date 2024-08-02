<?php

namespace App\Jobs;

use Illuminate\Foundation\Queue\Queueable;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AttendanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $limit = Carbon::createFromTime('0', '0', '0');
        $currentTime = Carbon::now();

        $refresh = $currentTime->greaterThanOrEqualTo($limit);
        if ($refresh) {
            $users = User::where('status', '2')->get(); // Fetch users

            foreach ($users as $user) {
                // Set default status to '1' (Absent)
                $status = '1';

                // Check if the user is on leave
              /*  if ($user->on_leave) {
                    $status = '3'; // On Leave
                } */

                // Create attendance record
                Attendance::create([
                    'user_id' => $user->id,
                    'date' => today(),
                    'status' => $status,
                ]);
            }
        }
    }
}
