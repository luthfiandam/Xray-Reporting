<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'equipment_type_id' => EquipmentType::factory(),
            'location_id' => Location::factory(),
            'equipment_code' => strtoupper($this->faker->unique()->bothify('EQP-###')),
            'name' => $this->faker->words(3, true),
            'brand' => $this->faker->company(),
            'model' => $this->faker->bothify('Model-###'),
            'view_mode' => $this->faker->randomElement(['single_view', 'dual_view', 'not_applicable']),
            'serial_number' => strtoupper($this->faker->unique()->bothify('SN-######')),
            'generator_serial_a' => strtoupper($this->faker->bothify('GEN-A-###')),
            'generator_serial_b' => null,
            'detector_serial' => strtoupper($this->faker->bothify('DET-###')),
            'software_version' => $this->faker->numerify('v#.#.#'),
            'firmware_version' => $this->faker->numerify('v#.#.#'),
            'ip_address' => $this->faker->ipv4(),
            'qr_code' => strtoupper($this->faker->unique()->bothify('QR-#####')),
            'installation_date' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'status' => 'operational',
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function dualView(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'view_mode' => 'dual_view',
                'generator_serial_b' => strtoupper($this->faker->bothify('GEN-B-###')),
            ];
        });
    }

    public function maintenance(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'maintenance',
            ];
        });
    }

    public function outOfService(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'out_of_service',
            ];
        });
    }
}