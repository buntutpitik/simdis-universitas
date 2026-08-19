<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        $admin = User::create([
            'uuid' => Str::uuid(),
            'position_id' => 1,
            'full_name' => 'Super Administrator',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('password'),
            'phone' => '081111111111',
            'avatar' => null,
            'is_active' => true,
        ]);

        $admin->assignRole('Administrator');

        $persuratan = User::create([
            'uuid' => Str::uuid(),
            'position_id' => 2,
            'full_name' => 'Admin Persuratan',
            'email' => 'persuratan@kampus.ac.id',
            'password' => Hash::make('password'),
            'phone' => '082222222222',
            'avatar' => null,
            'is_active' => true,
        ]);

        $persuratan->assignRole('Admin Persuratan');

        $rektor = User::create([
            'uuid' => Str::uuid(),
            'position_id' => 3,
            'full_name' => 'Rektor',
            'email' => 'rektor@kampus.ac.id',
            'password' => Hash::make('password'),
            'phone' => '083333333333',
            'avatar' => null,
            'is_active' => true,
        ]);

        $rektor->assignRole('Rektor');

        $staff = User::create([
            'uuid' => Str::uuid(),
            'position_id' => 4,
            'full_name' => 'Staff',
            'email' => 'staff@kampus.ac.id',
            'password' => Hash::make('password'),
            'phone' => '084444444444',
            'avatar' => null,
            'is_active' => true,
        ]);

        $staff->assignRole('Staf');
    }
}