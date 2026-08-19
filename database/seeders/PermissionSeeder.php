<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]
            ->forgetCachedPermissions();

        Permission::query()->delete();

        $permissions = [

            'dashboard.view',

            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            'positions.view',
            'positions.create',
            'positions.edit',
            'positions.delete',

            'incoming.view',
            'incoming.create',
            'incoming.edit',
            'incoming.delete',

            'outgoing.view',
            'outgoing.create',
            'outgoing.edit',
            'outgoing.delete',

            'disposition.view',
            'disposition.create',
            'disposition.edit',
            'disposition.delete',
            'disposition.process',
            'disposition.complete',

            'reports.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}