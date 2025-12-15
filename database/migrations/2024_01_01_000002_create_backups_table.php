<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('backup_schedule_id')->nullable()->constrained('backup_schedules')->onDelete('set null');
            $table->string('name');
            $table->enum('type', ['database', 'codebase', 'combined'])->default('database');
            $table->enum('status', ['pending', 'running', 'success', 'failed', 'partial'])->default('pending');
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->bigInteger('file_size')->nullable(); // Size in bytes
            $table->string('storage_disk')->default('local');
            $table->json('database_options')->nullable();
            $table->json('codebase_options')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->text('error_message')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};

