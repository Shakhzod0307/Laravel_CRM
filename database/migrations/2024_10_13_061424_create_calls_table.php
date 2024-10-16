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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
          $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
          $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
          $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
          $table->enum('type', ['inbound', 'outbound'])->default('inbound');
          $table->text('description')->nullable();
          $table->unsignedInteger('duration')->default(0);
          $table->timestamp('started_at')->nullable();
          $table->timestamp('ended_at')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
