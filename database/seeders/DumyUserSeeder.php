<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DumyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u = User::firstOrCreate([
            'name' => 'Super Adm',
            'email' => 'admin2@mail.com',

        ], ['password' => Hash::make('superAdmin123!.'),]);
        $u->assignRole('SUPER ADMIN PERENCANAAN');

        $u = User::firstOrCreate([
            'name' => 'PPK',
            'email' => 'ppk@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('PPK');

        $u = User::firstOrCreate([
            'name' => 'Staff PPK',
            'email' => 'staff@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('STAF PPK');

        $u = User::firstOrCreate([
            'name' => 'SPI',
            'email' => 'spi@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('SPI');

        $u = User::firstOrCreate([
            'name' => 'BENDAHARA',
            'email' => 'bendahara@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('BENDAHARA');

        $u = User::firstOrCreate([
            'name' => 'Pelaksana',
            'email' => 'pelaksana@mail.com',

        ], ['password' => Hash::make('123'),]);
        $u->assignRole('Pelaksana Kegiatan');
    }
}
