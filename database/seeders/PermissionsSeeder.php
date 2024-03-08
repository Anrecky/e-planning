<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat permission
        Permission::create(['name' => 'input data', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit data', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete data', 'guard_name' => 'web']);
    }
}
