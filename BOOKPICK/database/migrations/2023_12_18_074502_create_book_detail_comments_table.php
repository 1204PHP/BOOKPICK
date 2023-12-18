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
        Schema::create('book_detail_comments', function (Blueprint $table) {
            $table->id('bdc_id');
            // 책 상세 댓글 PK
            // default : big_int, pk, auto_increment

            $table->string('bdc_comment', 1000);
            // 댓글 내용
            // varchar 생성(1000) / default : not null

            $table->unsignedBigInteger('bdc_like')->default(0);
            // 좋아요
            // unsignedBigInteger 생성 / default : not null, 플래그 0
            // 좋아요는 음수가 될 수 없는 값으로, 부호 없는 정수형으로 정의

            $table->timestamps();
            // created_at, updated_at 라라벨 내부 설정 값으로 자동 생성 / default : null
            
            $table->softDeletes();
            // deleted_at 라라벨 내부 설정 값으로 자동 생성 / default : nullable
            
            $table->unsignedBigInteger('b_id');
            $table->foreign('b_id')->references('b_id')->on('book_infos');
            $table->unsignedBigInteger('u_id');
            $table->foreign('u_id')->references('u_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_detail_comments');
    }
};
