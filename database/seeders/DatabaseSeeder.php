<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use App\Models\PPK;
use App\Models\User;
use App\Models\Verificator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        if (config('app.env') == 'local') {
            // Path to your SQL file
            $sqlFilePath = database_path('seeders/eplanning.sql');

            // Check if the file exists
            if (File::exists($sqlFilePath)) {
                // Read the SQL file
                $sql = File::get($sqlFilePath);

                // Execute the SQL queries
                DB::unprepared($sql);

                $this->command->info('SQL file seeded successfully.');
            } else {
                $this->command->error('SQL file not found.');
            }
        }
        // Check if the user with email 'admin@mail.com' already exists
        $adminUser = User::where('email', 'admin@mail.com')->first();

        // If the user doesn't exist, create it
        if (!$adminUser) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make(env('ADMIN_PASS')),
            ]);
        }

        $this->call([RolesAndPermissionsSeeder::class]);
        $this->call([DumyUserSeeder::class]);
        $roles = [
            'PPK',
            'SPI',
            'STAF PPK',
            'SUPER ADMIN PERENCANAAN',
            'ADMIN FAKULTAS/UNIT',
            'KPA (REKTOR)',
            'BENDAHARA',
            'Pelaksana Kegiatan',
        ];

        if (env('APP_ENV') === 'local') {
            // for testing
            // PPK::factory(123)->create();
            // Verificator::factory(456)->create();
            User::factory(250)->create()->each(function ($user) use ($roles) {
                $user->assignRole($roles[array_rand($roles)]);
            });
            $fakultas1User = User::factory()->create([
                'name' => 'fakultas 1',
                'email' => 'fakultas1@mail.com',
                'password' => 'password'
            ]);
            $f1e = new Employee([
                'id' => '123456789',
                'position' => 'Staff Admin Fakultas 1',
                'work_unit_id' => 3,
            ]);
            $fakultas1User->assignRole('ADMIN FAKULTAS/UNIT');
            $fakultas1User->employee()->save($f1e);
        }
        User::where('name', 'Admin')->first()->assignRole('SUPER ADMIN PERENCANAAN');
    }
}
