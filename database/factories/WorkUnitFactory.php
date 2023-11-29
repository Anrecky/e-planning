<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WorkUnit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkUnit>
 */
class WorkUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company, // Generates a fake company name
            'code' => $this->faker->optional()->bothify('???-###'), // Generates a random code with optional presence
        ];
    }
}
