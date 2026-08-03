<?php

namespace Database\Factories;

use App\Models\WorkOrder;
use App\Models\Equipment;
use App\Models\MaintenanceType;
use App\Models\MaintenanceFrequency;
use App\Models\ChecklistTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WorkOrderFactory extends Factory
{
    protected $model = WorkOrder::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'work_order_number' => strtoupper($this->faker->unique()->bothify('WO-#####')),
            'equipment_id' => Equipment::factory(),
            'maintenance_type_id' => MaintenanceType::factory(),
            'maintenance_frequency_id' => MaintenanceFrequency::factory(),
            'checklist_template_id' => ChecklistTemplate::factory(),
            'created_by' => User::factory(),
            'assigned_to' => User::factory(),
            'approved_by' => null,
            'status' => 'draft',
            'priority' => $this->faker->randomElement(['low', 'normal', 'high', 'critical']),
            'scheduled_at' => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
            'started_at' => null,
            'submitted_at' => null,
            'approved_at' => null,
            'closed_at' => null,
            'problem_description' => $this->faker->optional()->sentence(),
            'action_taken' => null,
            'final_condition' => 'not_assessed',
            'notes' => $this->faker->optional()->sentence(),
            'ocr_reviewed' => false,
            'sync_status' => 'synced',
        ];
    }

    public function inProgress(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'in_progress',
                'started_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            ];
        });
    }

    public function submitted(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'submitted',
                'started_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
                'submitted_at' => $this->faker->dateTimeBetween('now', '+1 day'),
            ];
        });
    }

    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
                'started_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
                'submitted_at' => $this->faker->dateTimeBetween('-10 days', 'now'),
                'approved_by' => User::factory(),
                'approved_at' => $this->faker->dateTimeBetween('now', '+1 day'),
            ];
        });
    }

    public function closed(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'closed',
                'started_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
                'submitted_at' => $this->faker->dateTimeBetween('-10 days', 'now'),
                'approved_by' => User::factory(),
                'approved_at' => $this->faker->dateTimeBetween('-5 days', 'now'),
                'closed_at' => $this->faker->dateTimeBetween('now', '+1 day'),
                'final_condition' => $this->faker->randomElement(['normal', 'limited', 'out_of_service']),
            ];
        });
    }

    public function critical(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => 'critical',
            ];
        });
    }
}