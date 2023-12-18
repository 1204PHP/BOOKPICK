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
        Schema::create('user_library', function (Blueprint $table) {
            
            $table->id('ul_id');
            // 유저 서재 PK
            // default : big_int, pk, auto_increment

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

            // 외래키 추가
            $table->foreignId('ulc_id')->constrained('user_library_comment')
            ->onDelete('set null')->index('user_library_ulc_id_foreign');
            // user_library 테이블->user_library_comment  테이블

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_library');
    }
};
