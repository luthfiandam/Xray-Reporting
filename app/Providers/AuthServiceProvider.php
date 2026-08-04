<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\{User, Equipment, WorkOrder, ChecklistResult, Evidence};
use App\Policies\{UserPolicy, EquipmentPolicy, WorkOrderPolicy, ChecklistResultPolicy, EvidencePolicy};

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Equipment::class => EquipmentPolicy::class,
        WorkOrder::class => WorkOrderPolicy::class,
        ChecklistResult::class => ChecklistResultPolicy::class,
        Evidence::class => EvidencePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}