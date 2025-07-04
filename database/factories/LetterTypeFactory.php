<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LetterType>
 */
class LetterTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Surat Keterangan Domisili',
                'Surat Pengantar SKCK',
                'Surat Keterangan Usaha',
                'Surat Keterangan Tidak Mampu'
            ]),
            'description' => $this->faker->sentence(),
            'required_fields' => [
                'keperluan' => 'text'
            ],
            'template' => 'Template surat untuk {nama}',
            'is_active' => true,
        ];
    }
}
