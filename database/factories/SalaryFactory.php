<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Salary>
 */
class SalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $endOfMonth = Carbon::now()->endOfMonth();

        // This generates a random DateTime between 30 days ago and 60 days ago.

        return [
            'user_id'=>User::factory(),
            'amount'=>$this->faker->randomFloat(2, 2000, 800000),
            'effective_date'=>$endOfMonth
        ];
    }
}
