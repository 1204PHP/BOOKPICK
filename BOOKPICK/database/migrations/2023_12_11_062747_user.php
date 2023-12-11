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
            $table->id();
            // default : big_int, pk, auto_increment
            $table->string('email')->unique();
            // varchar 생성 / default : unique, not null
            $table->string('password');
            // varchar 생성 / default : not null
            $table->string('nickname', 20)->unique();
            // varchar 생성(20) / default : unique, not null
            $table->integer('postcode'); 
            // integer 생성 / default : not null
            $table->string('basic_address');
            // varchar 생성 / default : not null
            $table->string('detail_address');
            // varchar 생성 / default : not null
            $table->string('gender');
            // varchar 생성 / default : not null
            $table->string('name', 50);
            // varchar 생성(50) / default : not null
            $table->date('birthdate');
            // date 날짜 형식 생성 / default : not null
            $table->string('tel', 11);
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
