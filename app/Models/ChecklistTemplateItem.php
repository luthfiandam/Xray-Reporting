<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistTemplateItem extends Model
{
    use HasFactory;

    protected $table = 'checklist_template_items';

    protected $fillable = [
        'checklist_template_id',
        'checklist_category_id',
        'item_code',
        'item_name',
        'input_type',
        'options_json',
        'is_required',
        'sequence',
        'help_text',
        'is_active',
    ];

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'options_json' => 'array',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ✅ RELATIONSHIP
    public function checklistTemplate()
    {
        return $this->belongsTo(ChecklistTemplate::class, 'checklist_template_id');
    }

    public function checklistCategory()
    {
        return $this->belongsTo(ChecklistCategory::class, 'checklist_category_id');
    }

    public function checklistResults()
    {
        return $this->hasMany(ChecklistResult::class, 'checklist_template_item_id');
    }
}