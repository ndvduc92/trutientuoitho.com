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
        Schema::create('shop_trades', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer("quantity")->default(1);
            $table->string('itemid');
            $table->string("char_id");
            $table->integer("price");
            $table->dateTime("date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_trades');
    }
};
