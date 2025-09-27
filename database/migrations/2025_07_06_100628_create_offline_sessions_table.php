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
        Schema::create('offline_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('char_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->enum('status', ['active', 'completed'])->default('active');
            $table->dateTime('last_calculated_at')->nullable();
            $table->timestamps();
        });

        Schema::create('offline_session_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offline_session_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedInteger('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_sessions');
    }
};
