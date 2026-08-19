<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutgoingLetterFactory extends Factory
{
    public function definition(): array
    {
        return [

            'agenda_number' => null,

            'letter_number' => strtoupper(fake()->bothify('SK-###/UNIV/????/2026')),

            'letter_date' => fake()->dateTimeBetween('-6 months'),

            'recipient' => fake()->company(),

            'regarding' => fake()->sentence(5),

            'priority' => fake()->randomElement([
                'Biasa',
                'Penting',
                'Segera',
                'Rahasia',
            ]),

            'attachment' => fake()->optional()->word(),

            'description' => fake()->optional()->paragraph(),

            'file' => null,

            'created_by' => User::query()->inRandomOrder()->value('id'),

        ];
    }
}