<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserHasTrained>
 */
class UserHasTrainedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exercise_id' => \App\Models\Exercise::factory(), // ou um ID específico
            'user_id' => \App\Models\User::factory(), // ou um ID específico
        ];
    }
}
