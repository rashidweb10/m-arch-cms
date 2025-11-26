<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('backup_manager_backups', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // database, codebase, full
            $table->json('destinations')->nullable();
            $table->unsignedBigInteger('size_bytes')->default(0);
            $table->string('status')->default('pending'); // pending, running, success, failed
            $table->string('path')->nullable();
            $table->string('disk')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('backup_manager_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_manager_backups');
        Schema::dropIfExists('backup_manager_settings');
    }
};


