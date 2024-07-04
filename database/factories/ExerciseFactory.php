<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trainer_id' => \App\Models\User::factory(), // ou um ID específico
            'user_id' => \App\Models\User::factory(), // ou um ID específico
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }
}
