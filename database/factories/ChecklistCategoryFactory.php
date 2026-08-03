<?php

namespace Database\Factories;

use App\Models\ChecklistCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistCategoryFactory extends Factory
{
    protected $model = ChecklistCategory::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->bothify('CAT-###')),
            'name' => $this->faker->unique()->words(2, true),
            'description' => $this->faker->sentence(),
            'sequence' => $this->faker->numberBetween(10, 100),
            'is_active' => true,
        ];
    }

    public function safety(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'SAFETY',
                'name' => 'Keamanan',
                'description' => 'Pemeriksaan keamanan peralatan',
            ];
        });
    }

    public function mechanical(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => 'MECHANICAL',
                'name' => 'Mekanik',
                'description' => 'Pemeriksaan komponen mekanik',
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