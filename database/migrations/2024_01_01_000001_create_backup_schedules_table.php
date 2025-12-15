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
        Schema::create('backup_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['database', 'codebase', 'combined'])->default('database');
            $table->enum('frequency', ['minutely', 'hourly', 'daily', 'weekly', 'monthly', 'custom'])->default('daily');
            $table->string('cron_expression')->nullable(); // For custom frequency
            $table->boolean('is_enabled')->default(true);
            $table->json('database_options')->nullable(); // {tables: [], exclude_tables: [], structure_only: false, data_only: false}
            $table->json('codebase_options')->nullable(); // {folders: [], exclude_folders: [], compression: 'zip'}
            $table->timestamp('last_run_at')->nullable();
            $table->timestamp('next_run_at')->nullable();
            $table->enum('last_status', ['success', 'failed', 'running'])->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_schedules');
    }
};

