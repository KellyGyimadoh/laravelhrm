<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Salary;
use App\Models\User;
use App\Models\UserLeave;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 departments
        $departments = Department::factory(10)->create();

        // Create users and assign each to a department
        foreach ($departments as $department) {
            // Create 5 users for each department
            $users = User::factory()->count(5)->forDepartment($department)->create();

            // Assign a random user as department head
            $randomUser = $users->random();
            $department->update(['department_head_id' => $randomUser->id]);

            // Create attendance records and salaries for each user
            foreach ($users as $user) {
                // Create attendance for the past 30 days
                Attendance::factory()->count(30)->create([
                    'user_id' => $user->id,
                    'date' => now()->subDays(rand(1, 30))->toDateString(), // Random date within the last 30 days
                ]);

                // Create user leaves
                UserLeave::factory()->count(20)->create(['user_id' => $user->id]);

                // Create salary and automatically create payroll via observer
                Salary::factory()->create(['user_id' => $user->id]);
            }
        }
    }
}
