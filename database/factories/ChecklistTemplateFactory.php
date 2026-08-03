<?php

namespace Database\Factories;

use App\Models\ChecklistTemplate;
use App\Models\EquipmentType;
use App\Models\MaintenanceFrequency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ChecklistTemplateFactory extends Factory
{
    protected $model = ChecklistTemplate::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'equipment_type_id' => EquipmentType::factory(),
            'maintenance_frequency_id' => MaintenanceFrequency::factory(),
            'name' => $this->faker->words(4, true),
            'version' => 1,
            'description' => $this->faker->sentence(),
            'is_active' => true,
            'effective_from' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'effective_until' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }

    public function withDateRange(): static
    {
        return $this->state(function (array $attributes) {
            $from = $this->faker->dateTimeBetween('-1 year', 'now');
            $until = $this->faker->dateTimeBetween($from, '+1 year');
            return [
                'effective_from' => $from,
                'effective_until' => $until,
            ];
        });
    }
}