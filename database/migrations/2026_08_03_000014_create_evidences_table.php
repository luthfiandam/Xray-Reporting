<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('evidences', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('work_order_id')->constrained('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();

            $table->enum('evidence_type', [
                'overview','nameplate','measurement','generator_test',
                'before','after','error','other'
            ])->default('other');

            $table->string('original_path', 1024);
            $table->string('watermarked_path', 1024)->nullable();
            $table->string('thumbnail_path', 1024)->nullable();
            $table->string('original_name', 255)->nullable();
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('caption', 500)->nullable();
            $table->unsignedSmallInteger('sequence')->default(100);
            $table->dateTime('taken_at')->nullable();
            $table->enum('watermark_status', ['pending','processed','failed','not_required'])->default('pending');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['work_order_id','evidence_type'], 'idx_evidences_work_order_type');
            $table->index(['work_order_id','sequence'], 'idx_evidences_sequence');
        });
    }
    public function down(): void { Schema::dropIfExists('evidences'); }
};
