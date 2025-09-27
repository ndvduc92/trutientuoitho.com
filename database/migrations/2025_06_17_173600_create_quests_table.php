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
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
            $table->string("type")->default("ingame");
            $table->timestamps();
        });

        Schema::create('quest_items', function (Blueprint $table) {
            $table->id();
            $table->string('itemid');
            $table->integer('quantity')->default(1);
            $table->boolean('bind')->default(true);
            $table->integer('quest_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
