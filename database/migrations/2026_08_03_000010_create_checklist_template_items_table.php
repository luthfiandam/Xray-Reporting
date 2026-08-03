<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('checklist_template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_template_id')->constrained('checklist_templates')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('checklist_category_id')->nullable()->constrained('checklist_categories')->cascadeOnUpdate()->nullOnDelete();
            $table->string('item_code', 80)->nullable();
            $table->string('item_name', 500);
            $table->enum('input_type', ['boolean','select','text','number','photo','multiselect'])->default('boolean');
            $table->json('options_json')->nullable();
            $table->boolean('is_required')->default(true);
            $table->unsignedSmallInteger('sequence')->default(100);
            $table->text('help_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['checklist_template_id','sequence'], 'uq_checklist_item_sequence');
            $table->index('is_active');
        });
    }
    public function down(): void { Schema::dropIfExists('checklist_template_items'); }
};
