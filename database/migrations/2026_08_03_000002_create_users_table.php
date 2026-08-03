<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name', 150);
            $table->string('username', 80)->unique();
            $table->string('email', 150)->nullable()->unique();
            $table->string('phone', 32)->nullable();
            $table->string('password');
            $table->string('technician_code', 50)->nullable()->unique();
            $table->enum('status', ['active','inactive','suspended'])->default('active');
            $table->dateTime('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->index('status');
        });
    }
    public function down(): void { Schema::dropIfExists('users'); }
};
