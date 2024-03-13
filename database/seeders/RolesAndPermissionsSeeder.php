<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['PPK', 'SPI', 'STAF PPK', 'SUPER ADMIN PERENCANAAN', 'ADMIN FAKULTAS/UNIT', 'KPA (REKTOR)', 'BENDAHARA', 'Pelaksana Kegiatan'];

        // Loop through the roles and create them
        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }
}
