<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $boughtAt = $this->faker->dateTimeThisYear;
        $expiresAt = (clone $boughtAt)->modify('+1 year');

        return [
            'trainer_id' => \App\Models\User::factory(), // ou um ID específico
            'bought_at' => $boughtAt,
            'expires_at' => $expiresAt,
            'price' => $this->faker->randomFloat(2, 10, 100), // Valor entre 10 e 1000 com duas casas decimais
            'is_renewable' => $this->faker->boolean, // Verdadeiro ou falso aleatoriamente
        ];
    }
}
