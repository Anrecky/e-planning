<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssetItem>
 */
class AssetItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->domainWord(),
            'description' => $this->faker->optional()->paragraph(),
            'category' => $this->faker->randomElement(['IT', 'NonIT']),
            'brand' => $this->faker->optional()->company(),
        ];
    }
}
