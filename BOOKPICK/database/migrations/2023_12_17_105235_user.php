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
        Schema::create('users', function (Blueprint $table) {
            
            $table->id('u_id');
            // 유저 PK
            // default : big_int, pk, auto_increment
            
            $table->string('u_email', 50)->unique();
            // 유저 이메일
            // varchar 생성(50) / default : unique, not null
            
            $table->string('u_password', 30);
            // 비밀번호
            // varchar 생성(30) / default : not null            
            
            $table->string('u_name', 50);
            // 이름
            // varchar 생성(50) / default : not null
            
            $table->date('u_birthdate');
            // 생년월일
            // date 날짜 형식 생성 / default : not null
            
            $table->string('u_tel', 11);
            // 휴대폰 번호
            // varchar 생성(11) / default : not null
            
            $table->unsignedBigInteger('u_postcode', 6);
            // 우편번호
            // unsignedBigInteger 생성(10) / default : not null
            // 우편번호는 음수불가 하기 때문에 unsignedBigInteger 생성
            
            $table->string('u_basic_address', 200);
            // 기본주소
            // varchar 생성(200) / default : not null
            
            $table->string('u_detail_address', 50)->nullable();
            // 상세주소
            // varchar 생성(50) / default : nullable            
            
            $table->timestamp('email_verified_at')->nullable();
            // 이메일 인증 날짜, 시간 저장 / default : nullable
            
            $table->rememberToken();
            // 로그인 상태 유지 목적
            
            $table->timestamps();
            // created_at, updated_at 라라벨 내부 설정 값으로 자동 생성 / default : null
            
            $table->softDeletes();
            // deleted_at 라라벨 내부 설정 값으로 자동 생성 / default : nullable

            // 외래키 추가
            $table->foreignId('bdc_id')->constrained('book_detail_comment')
            ->onDelete('set null')->index('users_bdc_id_foreign');
            // users 테이블->book_detail_comment  테이블
            $table->foreignId('uw_id')->constrained('user_wishlist')
            ->onDelete('set null')->index('users_uw_id_foreign');
            // users 테이블->user_wishlist 테이블
            $table->foreignId('ul_id')->constrained('user_library')
            ->onDelete('set null')->index('users_ul_id_foreign');
            // users 테이블->user_library 테이블
            $table->foreignId('ulc_id')->constrained('user_library_comment')
            ->onDelete('set null')->index('users_ulc_id_foreign');
            // users 테이블->user_library_comment 테이블

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
        Schema::dropIfExists('users');
    }
};
