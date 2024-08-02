<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserLeave>
 */
class UserLeaveFactory extends Factory
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
         $endDate= $this->faker->dateTimeBetween('now','+100 days');

       // Generate a random check-in time as a Carbon instance
       $checkInTime = Carbon::instance($date)->addHours($this->faker->numberBetween(8, 10));
        return [
            'user_id'=>User::factory(),
            'type'=>fake()->randomElement(['sick','vacation','emergency']),
            'status'=>fake()->randomElement([1,2,3]),
            'start_date'=>$date,
            'end_date'=>$endDate
        ];
    }
}
