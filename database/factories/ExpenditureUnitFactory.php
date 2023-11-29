<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExpenditureUnit>
 */
class ExpenditureUnitFactory extends Factory
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
