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
        Schema::create('api_cate', function (Blueprint $table) {
            $table->id('ac_id');
            // api category PK
            // default : big_int, pk, auto_increment

            $table->string('ac_name', 50);
            // api 종류
            // varchar 생성(50) / default : not null

            // 외래키 추가
            $table->foreignId('ba_id')->constrained('book_api')
            ->onDelete('set null')->index('api_cate_ba_id_foreign');
            // api_cate 테이블->book_api 테이블
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_cate');
    }
};
