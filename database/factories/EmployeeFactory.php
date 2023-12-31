<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'job_role' => $this->faker->name,
            'bio' => $this->faker->paragraphs(3, true),
            'user_id' => User::factory()->create()->id
        ];
    }
}
