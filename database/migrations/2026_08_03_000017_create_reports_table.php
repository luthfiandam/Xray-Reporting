<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('generated_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();

            $table->enum('report_type', ['whatsapp','pdf','excel']);
            $table->enum('status', ['queued','processing','generated','failed'])->default('queued');
            $table->longText('content')->nullable();
            $table->string('file_path', 1024)->nullable();
            $table->unsignedSmallInteger('version')->default(1);
            $table->text('error_message')->nullable();
            $table->dateTime('generated_at')->nullable();
            $table->timestamps();

            $table->unique(['work_order_id','report_type','version'], 'uq_report_version');
            $table->index(['work_order_id','report_type'], 'idx_reports_work_order_type');
            $table->index('status');
            $table->index('generated_at');
        });
    }
    public function down(): void { Schema::dropIfExists('reports'); }
};
