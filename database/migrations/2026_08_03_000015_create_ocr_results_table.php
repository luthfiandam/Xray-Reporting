<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ocr_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('evidence_id')->constrained('evidences')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();

            $table->string('engine_name', 100)->default('tesseract');
            $table->string('engine_version', 50)->nullable();
            $table->enum('status', ['queued','processing','completed','failed','reviewed'])->default('queued');
            $table->longText('raw_text')->nullable();
            $table->json('parsed_values')->nullable();
            $table->json('confidence_json')->nullable();
            $table->decimal('average_confidence', 5, 2)->nullable();
            $table->unsignedInteger('processing_time_ms')->nullable();
            $table->text('error_message')->nullable();
            $table->dateTime('reviewed_at')->nullable();
            $table->enum('review_status', ['pending','accepted','edited','rejected'])->default('pending');
            $table->timestamps();

            $table->index('status');
            $table->index('review_status');
        });
    }
    public function down(): void { Schema::dropIfExists('ocr_results'); }
};
