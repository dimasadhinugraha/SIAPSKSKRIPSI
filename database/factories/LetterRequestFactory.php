<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LetterRequest>
 */
class LetterRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'request_number' => 'REQ-' . date('Ymd') . '-' . str_pad($this->faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'user_id' => \App\Models\User::factory(),
            'letter_type_id' => \App\Models\LetterType::factory(),
            'form_data' => [
                'keperluan' => $this->faker->sentence()
            ],
            'status' => $this->faker->randomElement(['pending_rt', 'pending_rw', 'approved_final']),
            'submitted_at' => now(),
        ];
    }
}
