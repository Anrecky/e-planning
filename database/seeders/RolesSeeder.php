<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create roles
        $roleAdmin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $roleOperator = Role::create(['name' => 'operator', 'guard_name' => 'web']);
        $roleRevenueTreasurer = Role::create(['name' => 'revenue_treasurer', 'guard_name' => 'web']);
        $roleAssetManager = Role::create(['name' => 'asset_manager', 'guard_name' => 'web']);
        $rolePPKStaff = Role::create(['name' => 'ppk_staff', 'guard_name' => 'web']);
        $rolePPK = Role::create(['name' => 'ppk', 'guard_name' => 'web']);
    }

}
