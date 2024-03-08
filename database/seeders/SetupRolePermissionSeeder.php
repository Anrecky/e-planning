<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetupRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mencari atau membuat role dan permission
        $role = Role::findByName('operator', 'web');
        $permission = Permission::findByName('input data', 'web');

        // Menetapkan permission ke role
        $role->givePermissionTo($permission);

        // Atau menetapkan banyak permission sekaligus
        // $role->syncPermissions(['edit articles', 'delete articles', 'publish articles']);
    }
}
