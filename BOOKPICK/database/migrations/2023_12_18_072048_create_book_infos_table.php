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
        Schema::create('book_infos', function (Blueprint $table) {
            $table->id('b_id');
            // 책 정보 PK
            // default : big_int, pk, auto_increment
            
            $table->string('b_ISBN')->unique();
            // 책 고유 번호
            // varchar 생성 / default : unique, not null
            // ### 알라딘 API를 통해 받아오는 책 고유 번호(b_ISBN)는 주로 문자열로 제공됩니다. 
            // 따라서 integer로 정의하는 것보다는 string으로 정의하는 것이 더 적절할 것입니다. 
            // 책 고유 번호에는 주로 숫자와 문자가 섞여 있을 수 있으며, 정수형으로 변환 시 일부 정보가 손실될 수 있습니다.
            
            $table->unsignedBigInteger('b_price');
            // 책 가격
            // unsignedBigInteger 생성 / default : not null
            // 책 가격은 음수가 될 수 없는 값으로, 부호 없는 정수형으로 정의
            
            $table->string('b_title', 500);
            // 책 제목
            // varchar 생성(100) / default : not null
            
            $table->string('b_author', 500);
            // 책 저자
            // varchar 생성(100) / default : not null
            
            $table->string('b_summary', 1000);
            // 책 내용
            // varchar 생성(1000) / default : not null
            
            $table->string('b_main_cate', 60);
            // 주 카테고리
            // varchar 생성(60) / default : not null
            
            $table->string('b_sub_cate', 150)->nullable();
            // 부 카테고리
            
            $table->date('b_publication_date');
            // 출판일
            // date 날짜 형식 생성 / default : not null
            
            $table->string('b_publisher', 100);
            // 출판사
            // varchar 생성(100) / default : not null
            
            $table->string('b_img_url', 300);
            // 책 이미지 주소
            // varchar 생성(300) / default : not null
            
            $table->string('b_product_url', 300);
            // 책 상품링크 주소
            // varchar 생성(300) / default : not null
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
        Schema::dropIfExists('book_infos');
    }
};
