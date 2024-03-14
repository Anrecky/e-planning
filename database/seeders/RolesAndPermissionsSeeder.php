<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $roles = [
            'PPK',
            'SPI',
            'STAF PPK',
            'SUPER ADMIN PERENCANAAN',
            'ADMIN FAKULTAS/UNIT',
            'KPA (REKTOR)',
            'BENDAHARA',
            'Pelaksana Kegiatan'
        ];

        // Define permissions
        $permissions = ['create user'];

        // Create permissions
        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        // Loop through the roles and create them
        foreach ($roles as $roleName) {
            $role = Role::create(['name' => $roleName]);

            // Assign "can create user" permission to SUPER ADMIN PERENCANAAN role
            if ($roleName === 'SUPER ADMIN PERENCANAAN') {
                $role->givePermissionTo('create user');
            }
        }
    }
}
