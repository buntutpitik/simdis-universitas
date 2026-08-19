<?php

namespace Database\Seeders;

use App\Models\IncomingLetter;
use App\Models\User;
use App\Services\NumberGenerator;
use Illuminate\Database\Seeder;

class IncomingLetterSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id');

        foreach (range(1, 20) as $i) {

            IncomingLetter::create([

                'agenda_number' => NumberGenerator::generate(
                    NumberGenerator::INCOMING,
                    'incoming_letters'
                ),

                'letter_number' => fake()->bothify('SM-###/UNIV/VIII/2026'),

                'letter_date' => fake()->dateTimeBetween('-3 months'),

                'received_date' => fake()->dateTimeBetween('-3 months'),

                'sender' => fake()->company(),

                'regarding' => fake()->sentence(),

                'priority' => fake()->randomElement([
                    'Biasa',
                    'Penting',
                    'Segera',
                    'Rahasia',
                ]),

                'status' => 'Baru',

                'attachment' => fake()->optional()->word(),

                'description' => fake()->paragraph(),

                'created_by' => $users->random(),

            ]);

        }
    }
}