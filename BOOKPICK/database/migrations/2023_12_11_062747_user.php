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
            // varchar 생성 / default : unique, not null
            $table->string('u_password');
            // varchar 생성 / default : not null
            $table->string('u_nickname', 20)->unique();
            // varchar 생성(20) / default : unique, not null
            $table->integer('u_postcode', 20); 
            // integer 생성 / default : not null
            $table->string('u_basic_address', 1000);
            // varchar 생성 / default : not null
            $table->string('u_detail_address', 1000);
            // varchar 생성 / default : not null
            $table->char('u_gender', 4);
            // char 생성 / default : not null
            $table->string('u_name', 50);
            // varchar 생성(50) / default : not null
            $table->date('u_birthdate');
            // date 날짜 형식 생성 / default : not null
            $table->string('u_tel', 11);
            // varchar 생성(11) / default : not null
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
