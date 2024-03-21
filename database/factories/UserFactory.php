<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
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

            // Assign random roles to the user
            $user->assignRole($roles[array_rand($roles)]);

            // Create Employee instance for the user
            $employee = Employee::factory()->create([
                'user_id' => $user->id,
                'position' => 'Some Position',
                'work_unit_id' => WorkUnit::factory()->create()->id,
                // Add other necessary fields for Employee model
            ]);

            // Add additional logic as needed
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
