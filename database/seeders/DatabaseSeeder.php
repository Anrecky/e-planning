<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\PPK;
use App\Models\Verificator;

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
        // for testing
        // PPK::factory(123)->create();
        // Verificator::factory(456)->create();
        $this->call([RolesAndPermissionsSeeder::class]);
        $this->call([DumyUserSeeder::class]);
    }
}
