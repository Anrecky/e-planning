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
        $permissions = [];
        $entities_actions = ['create', 'see', 'update', 'delete'];
        $main_menu_actions = ['view', 'approval'];
        $entities = ['user'];
        $main_menu = ['payments', 'reporting', 'budgeting', 'administration', 'planning'];

        foreach ($entities as $entity) {
            foreach ($entities_actions as $action) {
                $permissions[] = $action . ' ' . $entity;
            }
        }

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
