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
        Schema::create('achievement_shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('itemid');
            $table->integer('price');
            $table->integer('stack')->default(1);
            $table->string("status")->default("active");
            $table->timestamps();
        });

        Schema::create('achievement_shop_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer("quantity")->default(1);
            $table->integer('shop_id');
            $table->string("char_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_shops');
    }
};
