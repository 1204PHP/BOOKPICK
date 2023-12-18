<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_api', function (Blueprint $table) {
            
            $table->id('ba_id');
            // 책 api PK
            // default : big_int, pk, auto_increment

            $table->integer('ba_rank', 10)->nullable();
            // api 번호
            // integer 생성(10) / default : nullable

            $table->dateTime('ba_at')->default(now());
            // api 호출일자
            // datetime 생성 / default : now

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_api');
    }
};
