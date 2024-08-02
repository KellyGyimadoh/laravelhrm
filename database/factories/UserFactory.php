<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'department_id' => null,
            'role'=>fake()->randomElement(['admin','staff']),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'position'=>fake()->randomElement(['unranked','ranked']),
            'image'=>fake()->imageUrl(),
            'status'=>fake()->randomElement([1,2]),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
    public function forDepartment(Department $department)
    {
        return $this->state(fn (array $attributes) => [
            'department_id' => $department->id,
        ]);
    }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
