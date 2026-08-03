<?php

namespace Database\Factories;

use App\Models\MeasurementTemplate;
use App\Models\EquipmentType;
use App\Models\MaintenanceFrequency;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeasurementTemplateFactory extends Factory
{
    protected $model = MeasurementTemplate::class;

    public function definition(): array
    {
        return [
            'equipment_type_id' => EquipmentType::factory(),
            'maintenance_frequency_id' => MaintenanceFrequency::factory(),
            'code' => strtoupper($this->faker->unique()->bothify('MEAS-###')),
            'name' => $this->faker->words(3, true),
            'generator' => $this->faker->randomElement(['A', 'B', 'NA']),
            'unit' => $this->faker->randomElement(['kV', 'mA', 'Hz', 'V', 'Ω', '%']),
            'minimum_value' => $this->faker->numberBetween(0, 50),
            'maximum_value' => $this->faker->numberBetween(50, 150),
            'decimal_precision' => 2,
            'sequence' => $this->faker->numberBetween(10, 100),
            'is_required' => true,
            'is_ocr_enabled' => $this->faker->boolean(60),
            'is_active' => true,
        ];
    }

    public function generatorA(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'generator' => 'A',
            ];
        });
    }

    public function generatorB(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'generator' => 'B',
            ];
        });
    }

    public function ocrEnabled(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_ocr_enabled' => true,
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