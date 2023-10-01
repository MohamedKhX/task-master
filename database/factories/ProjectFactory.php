<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'status' => $this->faker->randomElement(['Not Started', 'In Progress', 'On Hold', 'Completed']),
            'priority' => $this->faker->randomElement(['Low', 'Normal', 'High', 'Urgent']),
            'budget' => $this->faker->optional()->randomFloat(2, 0, 100000),
            'task_status_template' => json_encode([
                'Open',
                'In Progress',
                'Blocked',
                'Completed'
            ]),
            'start_date' => $this->faker->optional()->dateTime(),
            'end_date' => $this->faker->optional()->dateTime(),
            'created_by' => User::factory()->create()->id,
            'manager_id' => User::factory()->create()->id,
            'team_id' => Team::factory()->create()->id,
        ];
    }
}
