<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Models\AccountCode;
use App\Models\ExpenditureUnit;
use App\Models\User;
use App\Models\ProgramTarget;
use App\Models\WorkUnit;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Path to your SQL file
        $sqlFilePath = database_path('seeders/e-planning.sql');
        $this->call([
            // RenstraSeeder::class,
            RolesSeeder::class,
        ]);
        // User::create([
        //     'name' => 'Admin2',
        //     'email' => 'admin2@mail.com',
        //     'password' => Hash::make(env('ADMIN_PASS')),
        //     'identity_number' => '001'
        // ])->assignRole('admin');

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
        // if (env('APP_ENV') === 'local') {
        //     ProgramTarget::factory(100)->create();
        //     WorkUnit::factory(100)->create();
        //     ExpenditureUnit::factory(100)->create();
        //     AccountCode::factory(100)->create();
        // }
    }
}
