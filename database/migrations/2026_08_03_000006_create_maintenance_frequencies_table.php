<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('maintenance_frequencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name', 100)->unique();
            $table->unsignedSmallInteger('interval_days')->nullable();
            $table->unsignedSmallInteger('sequence')->default(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('sequence');
        });
    }
    public function down(): void { Schema::dropIfExists('maintenance_frequencies'); }
};
