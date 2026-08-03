<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChecklistCategory extends Model
{
    use HasFactory;

    protected $table = 'checklist_categories';

    protected $fillable = [
        'code',
        'name',
        'description',
        'sequence',
        'is_active',
    ];

    public $timestamps = true;

    // ✅ RELATIONSHIP
    public function checklistTemplateItems()
    {
        return $this->hasMany(ChecklistTemplateItem::class, 'checklist_category_id');
    }
}