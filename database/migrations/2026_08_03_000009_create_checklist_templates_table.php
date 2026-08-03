<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('checklist_templates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('equipment_type_id')->constrained('equipment_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('maintenance_frequency_id')->constrained('maintenance_frequencies')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name', 150);
            $table->unsignedSmallInteger('version')->default(1);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();
            $table->timestamps();
            $table->unique(['equipment_type_id','maintenance_frequency_id','version'], 'uq_checklist_template_version');
            $table->index(['equipment_type_id','maintenance_frequency_id','is_active'], 'idx_checklist_template_lookup');
        });
    }
    public function down(): void { Schema::dropIfExists('checklist_templates'); }
};
