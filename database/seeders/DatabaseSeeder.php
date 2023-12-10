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
        User::create(['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => Hash::make(env('ADMIN_PASS'))]);
        $this->call([
            RenstraSeeder::class,
        ]);
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
        // if (env('APP_ENV') === 'local') {
        //     ProgramTarget::factory(100)->create();
        //     WorkUnit::factory(100)->create();
        //     ExpenditureUnit::factory(100)->create();
        //     AccountCode::factory(100)->create();
        // }
    }
}
