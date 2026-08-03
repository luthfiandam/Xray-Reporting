<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('checklist_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sequence')->default(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('sequence');
        });
    }
    public function down(): void { Schema::dropIfExists('checklist_categories'); }
};
