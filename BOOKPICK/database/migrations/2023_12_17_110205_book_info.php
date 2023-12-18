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
        Schema::create('book_info', function (Blueprint $table) {
            
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
            
            $table->string('b_title', 100);
            // 책 제목
            // varchar 생성(100) / default : not null
            
            $table->string('b_author', 100);
            // 책 저자
            // varchar 생성(100) / default : not null
            
            $table->string('b_summary', 1000);
            // 책 내용
            // varchar 생성(1000) / default : not null
            
            $table->string('b_main_cate', 60);
            // 주 카테고리
            // varchar 생성(60) / default : not null
            
            $table->unsignedBigInteger('b_sub_cate')->nullable();
            // 부 카테고리
            // unsignedBigInteger 생성 / default : nullable
            // 부 카테고리는 음수가 될 수 없는 값으로, 부호 없는 정수형으로 정의
            
            $table->date('b_publication_date');
            // 출판일
            // date 날짜 형식 생성 / default : not null
            
            $table->string('b_publisher', 100);
            // 출판사
            // varchar 생성(100) / default : not null
            
            $table->string('b_img_url', 300);
            // 책 이미지 주소
            // varchar 생성(300) / ddefault : not null
            
            $table->string('b_product_url', 300);
            // 책 상품링크 주소
            // varchar 생성(300) / ddefault : not null

            // 외래키 추가
            $table->foreignId('ba_id')->constrained('book_api')
            ->onDelete('set null')->index('book_info_ba_id_foreign');
            // book_info 테이블->book_api 테이블
            $table->foreignId('bdc_id')->constrained('book_detail_comment')
            ->onDelete('set null')->index('book_info_bdc_id_foreign');
            // book_info 테이블->book_detail_comment 테이블
            $table->foreignId('uw_id')->constrained('user_wishlist')
            ->onDelete('set null')->index('book_info_uw_id_foreign');
            // book_info 테이블->user_wishlist 테이블
            $table->foreignId('ul_id')->constrained('user_library')
            ->onDelete('set null')->index('book_info_ul_id_foreign');
            // book_info 테이블->user_library 테이블
            
            // 인덱스 생성 이유
            // 1) 조인 연산 속도 향상
            // 2) 코드 가독성 향상
            // 3) 관례 : 라라벨은 자동으로 인덱스 생성하지만, 명시적 지정이 의도 전달 확실

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_info');
    }
};
