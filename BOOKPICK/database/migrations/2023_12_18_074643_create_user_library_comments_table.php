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
        Schema::create('user_library_comments', function (Blueprint $table) {
            $table->id('ulc_id');
            // 유저 서재 메모 PK
            // default : big_int, pk, auto_increment

            $table->string('ulc_comment', 1000);
            // 유저 서재 메모 내용
            // varchar 생성(1000)/ default : not null

            $table->timestamps();
            // created_at, updated_at 라라벨 내부 설정 값으로 자동 생성 / default : null
            
            $table->softDeletes();
            // deleted_at 라라벨 내부 설정 값으로 자동 생성 / default : nullable

            $table->unsignedBigInteger('ul_id');
            $table->foreign('ul_id')->references('ul_id')->on('user_libraries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_library_comments');
    }
};
