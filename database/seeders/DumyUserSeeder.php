<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DumyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u = User::create([
            'name' => 'Super Adm',
            'email' => 'admin2@mail.com',
            'identity_number' => '1',
            'password' => Hash::make('superAdmin123!.'),
        ]);
        $u->assignRole('SUPER ADMIN PERENCANAN');

        $u = User::create([
            'name' => 'PPK',
            'email' => 'ppk@mail.com',
            'identity_number' => '2',
            'password' => Hash::make('123'),
        ]);
        $u->assignRole('PPK');

        $u = User::create([
            'name' => 'Staff PPK',
            'email' => 'staff@mail.com',
            'identity_number' => '3',
            'password' => Hash::make('123'),
        ]);
        $u->assignRole('STAF PPK');

        $u = User::create([
            'name' => 'SPI',
            'email' => 'spi@mail.com',
            'identity_number' => '4',
            'password' => Hash::make('123'),
        ]);
        $u->assignRole('SPI');

        $u = User::create([
            'name' => 'BENDAHARA',
            'email' => 'bendahara@mail.com',
            'identity_number' => '5',
            'password' => Hash::make('123'),
        ]);
        $u->assignRole('BENDAHARA');

        $u = User::create([
            'name' => 'Pelaksana',
            'email' => 'pelaksana@mail.com',
            'identity_number' => '6',
            'password' => Hash::make('123'),
        ]);
        $u->assignRole('Pelaksana Kegiatan');
    }
}
