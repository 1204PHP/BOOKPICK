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
        Schema::create('user', function (Blueprint $table) {
            $table->id('u_id');
            // default : big_int, pk, auto_increment
            $table->string('u_email')->unique();
            // 이메일
            // varchar 생성 / default : unique, not null
            $table->string('u_password');
            // 비밀번호
            // varchar 생성 / default : not null            
            $table->string('u_name', 50);
            // 이름
            // varchar 생성(50) / default : not null
            $table->date('u_birthdate');
            // 생년월일
            // date 날짜 형식 생성 / default : not null
            $table->string('u_tel', 11);
            // 휴대폰 번호
            // varchar 생성(11) / default : not null
            $table->integer('u_postcode', 20);
            // 우편번호
            // integer 생성 / default : not null
            $table->string('u_basic_address', 1000);
            // 기본주소
            // varchar 생성 / default : not null
            $table->string('u_detail_address', 1000);
            // 상세주소
            // varchar 생성 / default : not null            
            $table->timestamp('email_verified_at')->nullable();
            // 이메일 인증 날짜, 시간 저장 / default : nullable
            $table->rememberToken();
            // 로그인 상태 유지 목적
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
        Schema::dropIfExists('_user');
    }
};
