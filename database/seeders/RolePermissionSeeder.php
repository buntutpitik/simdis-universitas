<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]
            ->forgetCachedPermissions();

        // Administrator
        Role::findByName('Administrator', 'web')
            ->syncPermissions(
                \Spatie\Permission\Models\Permission::all()
            );

        // Admin Persuratan
        Role::findByName('Admin Persuratan', 'web')
            ->syncPermissions([
                'dashboard.view',

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
                'disposition.process',
                'disposition.complete',
            ]);

        // Rektor
        Role::findByName('Rektor', 'web')
            ->syncPermissions([
                'dashboard.view',

                'incoming.view',

                'outgoing.view',

                'disposition.view',
                'disposition.process',
                'disposition.complete',

                'reports.view',
            ]);

        // Staff
        Role::findByName('Staf', 'web')
            ->syncPermissions([
                'dashboard.view',

                'incoming.view',
                
                'outgoing.view',
                'outgoing.create',

                'disposition.view',
                'disposition.process',
                'disposition.complete',
            ]);
    }
}