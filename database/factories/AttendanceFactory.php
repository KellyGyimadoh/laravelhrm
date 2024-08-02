<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          // Randomly choose whether to generate a date in the past or future
          $date = $this->faker->boolean(50)
          ? $this->faker->dateTimeBetween('-30 days', 'now') // Random date in the past 30 days
          : $this->faker->dateTimeBetween('now', '+30 days'); // Random date in the next 30 days


        // Generate a random check-in time as a Carbon instance
        $checkInTime = Carbon::instance($date)->addHours($this->faker->numberBetween(8, 10));
  return [
            'user_id'=>User::factory(),
            'date'=>$date->format('Y-m-d'),
            'check_in_time'=> $checkInTime->format('Y-m-d H:i:s'),
            'status'=>fake()->randomElement([1,2])
        ];
    }
}
