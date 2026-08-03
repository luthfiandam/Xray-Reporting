<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('equipment_type_id')->constrained('equipment_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('location_id')->constrained('locations')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('equipment_code', 50)->unique();
            $table->string('name', 150);
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->enum('view_mode', ['single_view','dual_view','not_applicable'])->default('not_applicable');
            $table->string('serial_number', 150)->nullable();
            $table->string('generator_serial_a', 150)->nullable();
            $table->string('generator_serial_b', 150)->nullable();
            $table->string('detector_serial', 150)->nullable();
            $table->string('software_version', 100)->nullable();
            $table->string('firmware_version', 100)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('qr_code', 255)->unique();
            $table->date('installation_date')->nullable();
            $table->enum('status', ['operational','maintenance','out_of_service','decommissioned','spare'])->default('operational');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('status');
            $table->index('serial_number');
            $table->index(['equipment_type_id','location_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('equipments'); }
};
