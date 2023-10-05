<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'department' => $this->faker->word,
            'location' => $this->faker->city,
            'active' => $this->faker->boolean,
            'leader_id' => Employee::factory()->create()->id,
            'created_by' => Employee::factory()->create()->id,
        ];
    }
}
