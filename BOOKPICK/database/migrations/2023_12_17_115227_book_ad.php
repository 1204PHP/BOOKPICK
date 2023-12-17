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
        Schema::create('book_ad', function (Blueprint $table) {

            $table->id('b_ad_id');
            // 책 api PK
            // default : big_int, pk, auto_increment

            $table->string('b_ad_type', 20);
            // 광고 종류
            // varchar 생성(20) / default : not null

            $table->string('b_ad_img_url', 300);
            // 광고 이미지 주소
            // varchar 생성(300) / default : not null

            $table->unsignedBigInteger('b_ad_num')->nullable();
            // 책 번호
            // unsignedBigInteger 생성 / default : nullable
            // 책 번호는 음수가 될 수 없는 값으로, 부호 없는 정수형으로 정의
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_ad');
    }
};
