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
        Schema::create('fames', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("type")->default("online");
            $table->integer("xu")->default(0);
            $table->timestamps();
        });

        Schema::create('fame_items', function (Blueprint $table) {
            $table->id();
            $table->string('itemid');
            $table->integer('quantity')->default(1);
            $table->boolean('bind')->default(true);
            $table->integer('fame_id');
            $table->timestamps();
        });

        Schema::create('fame_users', function (Blueprint $table) {
            $table->id();
            $table->integer('fame_id');
            $table->integer('user_id');
            $table->integer('char_id');
            $table->dateTime("date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fames');
    }
};
