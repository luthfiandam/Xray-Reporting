<?php

namespace Database\Factories;

use App\Models\MaintenanceFrequency;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFrequencyFactory extends Factory
{
    protected $model = MaintenanceFrequency::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->bothify('FREQ-###')),
            'name' => $this->faker->unique()->words(2, true),
            'interval_days' => $this->faker->randomElement([1, 7, 30, 90, 180, 365]),
            'sequence' => $this->faker->numberBetween(10, 100),
            'is_active' => true,
        ];
    }

    public function daily(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'DAILY',
                'name' => 'Harian',
                'interval_days' => 1,
                'sequence' => 10,
            ];
        });
    }

    public function weekly(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'WEEKLY',
                'name' => 'Mingguan',
                'interval_days' => 7,
                'sequence' => 20,
            ];
        });
    }

    public function monthly(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'MONTHLY',
                'name' => 'Bulanan',
                'interval_days' => 30,
                'sequence' => 30,
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