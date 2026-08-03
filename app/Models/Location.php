<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    protected $fillable = [
        'parent_id',
        'code',
        'name',
        'description',
        'is_active',
    ];

    public $timestamps = true;

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'location_id');
    }
}