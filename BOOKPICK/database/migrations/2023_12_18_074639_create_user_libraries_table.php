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
        Schema::create('user_libraries', function (Blueprint $table) {
            $table->id('ul_id');
            // 유저 서재 PK
            // default : big_int, pk, auto_increment
            $table->unsignedBigInteger('b_id');
            $table->foreign('b_id')->references('b_id')->on('book_infos');
            $table->unsignedBigInteger('u_id');
            $table->foreign('u_id')->references('u_id')->on('users');

            $table->integer('ul_flg')->default(0);

            $table->date('ul_start_at');
            // 읽기 시작한 날짜
            // date 날짜 형식 생성 / default : not null

            $table->date('ul_end_at');
            // 읽기 끝나는 날짜
            // date 날짜 형식 생성 / default : not null

            $table->timestamps();
            // created_at, updated_at 라라벨 내부 설정 값으로 자동 생성 / default : null
            
            $table->softDeletes();
            // deleted_at 라라벨 내부 설정 값으로 자동 생성 / default : nullable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_libraries');
    }
};
