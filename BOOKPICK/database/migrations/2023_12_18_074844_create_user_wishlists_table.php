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
        Schema::create('user_wishlists', function (Blueprint $table) {
            $table->id('uw_id');
            $table->unsignedBigInteger('b_id');
            $table->foreign('b_id')
                ->references('b_id')
                ->on('book_infos')
                ->onUpdate('cascade')  // onUpdate cascade 설정
                ->onDelete('cascade'); // onDelete cascade 설정

            $table->unsignedBigInteger('u_id');
            $table->foreign('u_id')
                ->references('u_id')
                ->on('users')
                ->onUpdate('cascade')  // onUpdate cascade 설정
                ->onDelete('cascade'); // onDelete cascade 설정
                
            // 책 api PK
            // default : big_int, pk, auto_increment
            $table->integer('uw_flg')->default(0);

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
        Schema::dropIfExists('user_wishlists');
    }
};
