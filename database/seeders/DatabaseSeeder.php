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

        if (env('APP_ENV') === 'local') {
            // for testing
            // PPK::factory(123)->create();
            // Verificator::factory(456)->create();
            User::factory(250)->create();
            $fakultas1User = User::factory()->create([
                'id' => 999,
                'name' => 'fakultas 1',
                'email' => 'fakultas1@mail.com',
                'password' => Hash::make('password')
            ]);
            $fakultas1User->assignRole('ADMIN FAKULTAS/UNIT');
        }
        User::where('name', 'Admin')->first()->assignRole('SUPER ADMIN PERENCANAAN');
    }
}
