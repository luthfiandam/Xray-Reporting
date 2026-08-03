<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('measurement_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_type_id')->constrained('equipment_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('maintenance_frequency_id')->nullable()->constrained('maintenance_frequencies')->cascadeOnUpdate()->nullOnDelete();
            $table->string('code', 80);
            $table->string('name', 150);
            $table->enum('generator', ['A','B','NA'])->default('NA');
            $table->string('unit', 30);
            $table->decimal('minimum_value', 18, 6)->nullable();
            $table->decimal('maximum_value', 18, 6)->nullable();
            $table->unsignedTinyInteger('decimal_precision')->default(2);
            $table->unsignedSmallInteger('sequence')->default(100);
            $table->boolean('is_required')->default(true);
            $table->boolean('is_ocr_enabled')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['equipment_type_id','maintenance_frequency_id','code','generator'], 'uq_measurement_template_parameter');
            $table->index(['equipment_type_id','maintenance_frequency_id','is_active'], 'idx_measurement_template_lookup');
            $table->index('sequence');
        });
    }
    public function down(): void { Schema::dropIfExists('measurement_templates'); }
};
