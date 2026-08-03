<?php

namespace Database\Factories;

use App\Models\MaintenanceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceTypeFactory extends Factory
{
    protected $model = MaintenanceType::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->bothify('MTYPE-###')),
            'name' => $this->faker->unique()->words(2, true),
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }

    public function preventive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'PM',
                'name' => 'Preventive Maintenance',
                'description' => 'Maintenance rutin untuk pencegahan',
            ];
        });
    }

    public function corrective(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'CM',
                'name' => 'Corrective Maintenance',
                'description' => 'Maintenance untuk perbaikan kerusakan',
            ];
        });
    }

    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}