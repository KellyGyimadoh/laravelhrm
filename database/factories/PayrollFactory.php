<?php

namespace Database\Factories;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payroll>
 */
class PayrollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date= $this->faker->dateTimeBetween('now','+100 days');

        return [
            'user_id'=>User::factory(),
            'salary'=>$this->faker->randomFloat(2, 2000, 800000),
            'paydate'=>$date,
            'status'=>fake()->randomElement([1,2,3])
        ];
    }
}
