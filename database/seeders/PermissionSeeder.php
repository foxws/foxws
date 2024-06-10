<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions
        Permission::firstOrCreate(['name' => 'edit posts']);
        Permission::firstOrCreate(['name' => 'delete posts']);
        Permission::firstOrCreate(['name' => 'publish posts']);
        Permission::firstOrCreate(['name' => 'unpublish posts']);

        // Create roles and assign created permissions
        $role = Role::firstOrCreate(['name' => 'moderator'])
            ->syncPermissions(['publish posts', 'unpublish posts']);

        $role = Role::firstOrCreate(['name' => 'super-admin']);
        $role->syncPermissions(Permission::all());
    }
}
