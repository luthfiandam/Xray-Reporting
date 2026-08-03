<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('checklist_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('checklist_template_item_id')->nullable()->constrained('checklist_template_items')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('completed_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();

            $table->string('item_code', 80)->nullable();
            $table->string('item_name', 500);
            $table->enum('input_type', ['boolean','select','text','number','photo','multiselect']);
            $table->enum('result_status', ['ok','not_ok','not_applicable','not_checked'])->nullable();
            $table->text('value_text')->nullable();
            $table->decimal('value_number', 18, 6)->nullable();
            $table->json('value_json')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedSmallInteger('sequence')->default(100);
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['work_order_id','checklist_template_item_id'], 'uq_checklist_result_item');
            $table->index('result_status');
        });
    }
    public function down(): void { Schema::dropIfExists('checklist_results'); }
};
