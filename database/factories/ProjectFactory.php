<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->randomElement(['Not Started', 'In Progress', 'On Hold', 'Completed']),
            'priority' => $this->faker->randomElement(['Low', 'Normal', 'High', 'Urgent']),
            'budget' => $this->faker->optional()->randomFloat(2, 0, 100000),
            'start_date' => $this->faker->optional()->dateTime(),
            'end_date' => $this->faker->optional()->dateTime(),
            'team_id' => Team::factory()->create()->id,
        ];
    }
}
