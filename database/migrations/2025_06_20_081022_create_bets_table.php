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
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');

            $table->string('bet_type'); // 'de', '3cang', 'chan_le', v.v.
            $table->string('number');   // số cược: vd '88' hoặc '288'
            $table->enum('odd_even', ['odd', 'even'])->default('odd'); // chan_le
            $table->date('date');  // ngày cược (kết quả sẽ được đối chiếu theo ngày này)

            $table->integer('amount');            // số tiền cược
            $table->enum('status', ['pending', 'won', 'lost'])->default('pending'); // null: chưa xử lý, true: trúng, false: trượt
            $table->decimal('prize')->nullable(); // tiền trúng nếu có

            $table->timestamps();
        });

        Schema::create('lottery_results', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique(); // ngày xổ
            $table->json('raw_data');       // lưu toàn bộ JSON kết quả API (backup)

            $table->string('giai_db'); // vd: 76288
            $table->string('so_de')->nullable();
            $table->string('ba_cang')->nullable();
            $table->enum('odd_even', ['odd', 'even'])->default('odd'); // chan_le

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};
