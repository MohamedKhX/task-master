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
            'job_role' => $this->faker->jobTitle,
            'bio' => $this->faker->paragraphs(3, true),
            'profile_photo_path' => $this->faker->imageUrl(),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
