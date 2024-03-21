<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->nik(),
            'position' => $this->faker->jobTitle,
            'letter_reference' => $this->faker->optional()->sentence(),
            'work_unit_id' => WorkUnit::factory(),
            'user_id' => User::factory(),
            'identity_type' => $this->faker->randomElement(['nip', 'nik', 'nidn']),
            // 'head_id' will be nullable and is not set by default
            // 'created_at' and 'updated_at' will be automatically set
        ];
    }
}
