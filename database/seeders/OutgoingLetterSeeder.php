<?php

namespace Database\Seeders;

use App\Models\OutgoingLetter;
use App\Models\User;
use App\Services\NumberGenerator;
use Illuminate\Database\Seeder;

class OutgoingLetterSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id');

        foreach (range(1, 20) as $i) {

            OutgoingLetter::create([

                'agenda_number' => NumberGenerator::generate(
                    NumberGenerator::OUTGOING,
                    'outgoing_letters'
                ),

                'letter_number' => fake()->bothify('SK-###/UNIV/VIII/2026'),

                'letter_date' => fake()->dateTimeBetween('-3 months'),

                'recipient' => fake()->company(),

                'regarding' => fake()->sentence(),

                'priority' => fake()->randomElement([
                    'Biasa',
                    'Penting',
                    'Segera',
                    'Rahasia',
                ]),

                'attachment' => fake()->optional()->word(),

                'description' => fake()->paragraph(),

                'created_by' => $users->random(),

            ]);

        }
    }
}