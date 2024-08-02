<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            // Assign department head id when creating department
            'department_head_id' => null,
            'email' => fake()->unique()->safeEmail(),
            'description' => fake()->sentence(6),
            'image' => fake()->imageUrl(),
            'status'=>fake()->randomElement([1,2])
        ];
    }

    // Custom state to assign department head
    public function withDepartmentHead(User $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'department_head_id' => $user->id,
            ];
        });
    }
}


