<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{
    User,
    WorkOrder,
    Equipment,
    ChecklistResult,
    MeasurementResult,
    Evidence,
    OcrResult,
    Report,
};
use App\Observers\{
    UserObserver,
    WorkOrderObserver,
    EquipmentObserver,
    ChecklistResultObserver,
    MeasurementResultObserver,
    EvidenceObserver,
    OcrResultObserver,
    ReportObserver,
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Observers
        User::observe(UserObserver::class);
        WorkOrder::observe(WorkOrderObserver::class);
        Equipment::observe(EquipmentObserver::class);
        ChecklistResult::observe(ChecklistResultObserver::class);
        MeasurementResult::observe(MeasurementResultObserver::class);
        Evidence::observe(EvidenceObserver::class);
        OcrResult::observe(OcrResultObserver::class);
        Report::observe(ReportObserver::class);
    }
}