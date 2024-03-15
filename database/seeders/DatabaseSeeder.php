<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        // User::create(['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => Hash::make(env('ADMIN_PASS'))]);

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

        // for testing
        // PPK::factory(123)->create();
        // Verificator::factory(456)->create();

        $this->call([RolesAndPermissionsSeeder::class]);
        $this->call([DumyUserSeeder::class]);
        // User::where('name', 'Admin')->first()->assignRole('SUPER ADMIN PERENCANAAN');
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
            User::factory(250)->create()->each(function ($user) use ($roles) {
                $user->assignRole($roles[array_rand($roles)]);
            });
        }
    }
}
