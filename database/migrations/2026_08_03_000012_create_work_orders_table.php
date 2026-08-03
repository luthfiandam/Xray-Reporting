<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('work_order_number', 50)->unique();
            $table->foreignId('equipment_id')->constrained('equipments')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('maintenance_type_id')->constrained('maintenance_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('maintenance_frequency_id')->nullable()->constrained('maintenance_frequencies')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('checklist_template_id')->nullable()->constrained('checklist_templates')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('assigned_to')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();

            $table->enum('status', [
                'draft','in_progress','ocr_review','ready_to_submit',
                'submitted','approved','closed','cancelled'
            ])->default('draft');
            $table->enum('priority', ['low','normal','high','critical'])->default('normal');

            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('closed_at')->nullable();

            $table->text('problem_description')->nullable();
            $table->text('action_taken')->nullable();
            $table->enum('final_condition', ['normal','limited','out_of_service','not_assessed'])->default('not_assessed');
            $table->text('notes')->nullable();
            $table->boolean('ocr_reviewed')->default(false);
            $table->enum('sync_status', ['synced','pending','conflict'])->default('synced');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['equipment_id','created_at'], 'idx_work_orders_equipment_created');
            $table->index(['assigned_to','status'], 'idx_work_orders_assigned_status');
            $table->index(['status','created_at'], 'idx_work_orders_status_created');
            $table->index('scheduled_at');
            $table->index('maintenance_type_id');
            $table->index('maintenance_frequency_id');
        });
    }
    public function down(): void { Schema::dropIfExists('work_orders'); }
};
