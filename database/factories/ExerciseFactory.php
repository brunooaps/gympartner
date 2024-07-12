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
        $isDone = $this->faker->boolean;

        return [
            'trainer_id' => \App\Models\User::factory(), // ou um ID específico
            'user_id' => \App\Models\User::factory(), // ou um ID específico
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'client_description' => $this->faker->paragraph,
            'done' => $isDone,
            'done_at' => $isDone ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
            'do_again_every' => $this->faker->randomDigit(2, 7), // Valor entre 10 e 1000 com duas casas decimais

        ];
    }
}
