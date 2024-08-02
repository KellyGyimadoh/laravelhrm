<?php

namespace App\Observers;

use App\Models\Payroll;
use App\Models\Salary;
use Carbon\Carbon;

class SalaryObserver
{
    /**
     * Handle the Salary "created" event.
     */
    public function created(Salary $salary): void
    {
        $endOfMonth = Carbon::now()->endOfMonth();

        Payroll::create([
            'user_id' => $salary->user_id,
            'salary' => $salary->amount,
            'paydate' => $endOfMonth,
            'status' => 1 // Default status, e.g., 'Unpaid'
        ]);
    }

    /**
     * Handle the Salary "updated" event.
     */
    public function updated(Salary $salary): void
    {
        //
    }

    /**
     * Handle the Salary "deleted" event.
     */
    public function deleted(Salary $salary): void
    {
        //
    }

    /**
     * Handle the Salary "restored" event.
     */
    public function restored(Salary $salary): void
    {
        //
    }

    /**
     * Handle the Salary "force deleted" event.
     */
    public function forceDeleted(Salary $salary): void
    {
        //
    }
}
