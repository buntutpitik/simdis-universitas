<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [

            [
                'code' => 'ADM',
                'name' => 'Administrator'
            ],

            [
                'code' => 'APS',
                'name' => 'Admin Persuratan'
            ],

            [
                'code' => 'REK',
                'name' => 'Rektor'
            ],

            [
                'code' => 'STF',
                'name' => 'Staf'
            ],

        ];

        foreach ($positions as $position) {

            Position::create($position);

        }
    }
}