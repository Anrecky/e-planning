<?php

namespace Database\Seeders;

use App\Models\Renstra;
use Illuminate\Database\Seeder;

class RenstraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Renstra::create([
            'vision' => null, // or an empty string '', depending on your requirement
            'mission' => null, // or an empty array []
            'iku' => null, // or an empty array []
            'capaian' => null, // or an empty array []
        ]);
    }
}
