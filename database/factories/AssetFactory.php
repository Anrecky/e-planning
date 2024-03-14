<?php

namespace Database\Factories;

use App\Models\AssetItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'asset_item_id' => AssetItem::all()->random()->id,
            'brand' => $this->faker->optional()->domainWord(),
            'year_acquisition' => $this->faker->numberBetween(2000, 2035),
            'code' => $this->faker->unique()->numerify('code-####'),
            'condition' => $this->faker->randomElement(['good', 'slightly', 'heavy']),
            'description' => $this->faker->paragraph(10),
        ];
    }
}
