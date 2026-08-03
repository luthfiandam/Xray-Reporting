<?php

namespace Database\Factories;

use App\Models\ChecklistTemplateItem;
use App\Models\ChecklistTemplate;
use App\Models\ChecklistCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistTemplateItemFactory extends Factory
{
    protected $model = ChecklistTemplateItem::class;

    public function definition(): array
    {
        return [
            'checklist_template_id' => ChecklistTemplate::factory(),
            'checklist_category_id' => ChecklistCategory::factory(),
            'item_code' => strtoupper($this->faker->unique()->bothify('ITEM-###')),
            'item_name' => $this->faker->words(3, true),
            'input_type' => $this->faker->randomElement(['boolean', 'select', 'text', 'number', 'photo', 'multiselect']),
            'options_json' => null,
            'is_required' => $this->faker->boolean(80),
            'sequence' => $this->faker->numberBetween(10, 100),
            'help_text' => $this->faker->optional()->sentence(),
            'is_active' => true,
        ];
    }

    public function boolean(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'input_type' => 'boolean',
                'options_json' => null,
            ];
        });
    }

    public function select(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'input_type' => 'select',
                'options_json' => ['Ok', 'Not Ok', 'Not Applicable'],
            ];
        });
    }

    public function number(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'input_type' => 'number',
                'options_json' => null,
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