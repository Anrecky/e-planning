<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AccountCode;
use App\Models\ExpenditureUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create(['name' => 'Admin', 'email' => 'admin@mail.com', 'password' => Hash::make(env('ADMIN_PASS'))]);
        $this->call([
            RenstraSeeder::class,
        ]);
        // ProgramTarget::factory(100)->create();
        // WorkUnit::factory(100)->create();
        // ExpenditureUnit::factory(100)->create();
        // AccountCode::factory(100)->create();
    }
}
