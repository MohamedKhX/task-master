<?php

namespace Database\Factories;

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
            'priority' => $this->faker->randomElement(['Low', 'Normal', 'High', 'Urgent']),
            'status_id' => $this->faker->numberBetween(1, 10),
            'created_by' => $this->faker->optional()->numberBetween(1, 10),
            'project_id' => $this->faker->optional()->numberBetween(1, 10),
            'parent_id' => $this->faker->optional()->numberBetween(1, 10),
            'start_date' => $this->faker->optional()->dateTime(),
            'end_date' => $this->faker->optional()->dateTime(),
        ];
    }
}
