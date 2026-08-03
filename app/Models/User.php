<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'name',
        'username',
        'email',
        'phone',
        'password',
        'technician_code',
        'status',
        'last_login_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ✅ RELATIONSHIP
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function workOrdersCreated()
    {
        return $this->hasMany(WorkOrder::class, 'created_by');
    }

    public function workOrdersAssigned()
    {
        return $this->hasMany(WorkOrder::class, 'assigned_to');
    }

    public function workOrdersApproved()
    {
        return $this->hasMany(WorkOrder::class, 'approved_by');
    }

    public function checklistResults()
    {
        return $this->hasMany(ChecklistResult::class, 'completed_by');
    }

    public function measurementResults()
    {
        return $this->hasMany(MeasurementResult::class, 'confirmed_by');
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class, 'uploaded_by');
    }

    public function ocrResults()
    {
        return $this->hasMany(OcrResult::class, 'reviewed_by');
    }

    public function generatedReports()
    {
        return $this->hasMany(Report::class, 'generated_by');
    }
}