<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('measurement_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('measurement_template_id')->nullable()->constrained('measurement_templates')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('ocr_result_id')->nullable()->constrained('ocr_results')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('confirmed_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();

            $table->string('measurement_code', 80);
            $table->string('measurement_name', 150);
            $table->enum('generator', ['A','B','NA'])->default('NA');
            $table->string('unit', 30);
            $table->decimal('ocr_value', 18, 6)->nullable();
            $table->decimal('manual_value', 18, 6)->nullable();
            $table->decimal('final_value', 18, 6);
            $table->decimal('minimum_value', 18, 6)->nullable();
            $table->decimal('maximum_value', 18, 6)->nullable();
            $table->boolean('is_within_range')->nullable();
            $table->enum('input_source', ['manual','ocr','ocr_edited','device'])->default('manual');
            $table->decimal('confidence', 5, 2)->nullable();
            $table->enum('validation_status', ['valid','warning','invalid','not_validated'])->default('not_validated');
            $table->text('notes')->nullable();
            $table->dateTime('confirmed_at');
            $table->timestamps();

            $table->unique(['work_order_id','measurement_code','generator'], 'uq_measurement_result_parameter');
            $table->index('input_source');
            $table->index('validation_status');
        });
    }
    public function down(): void { Schema::dropIfExists('measurement_results'); }
};
