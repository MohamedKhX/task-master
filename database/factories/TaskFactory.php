<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->optional()->text,
            'priority' => $this->faker->randomElement(['Low', 'High', 'Critical']),
            'status' => $this->faker->randomElement(['Completed', 'In Progress', 'Pending']),
            'created_by' => Employee::factory()->create()->id,
            'project_id' => Project::factory()->create()->id,
            'start_date' => $this->faker->optional()->dateTime(),
            'end_date' => $this->faker->optional()->dateTime(),
        ];
    }
}
