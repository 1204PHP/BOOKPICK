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
        Schema::create('book_apis', function (Blueprint $table) {
            $table->id('ba_id');
            // 책 api PK
            // default : big_int, pk, auto_increment

            $table->integer('ba_rank')->nullable();
            // api 번호
            // integer 생성(10) / default : nullable

            $table->timestamps();
            // created_at, updated_at 라라벨 내부 설정 값으로 자동 생성 / default : null
            
            $table->softDeletes();
            // deleted_at 라라벨 내부 설정 값으로 자동 생성 / default : nullable
            
            $table->unsignedBigInteger('b_id');
            $table->foreign('b_id')
                ->references('b_id')
                ->on('book_infos')
                ->onUpdate('cascade')  // onUpdate cascade 설정
                ->onDelete('cascade'); // onDelete cascade 설정

            $table->unsignedBigInteger('ac_id');
            $table->foreign('ac_id')
                ->references('ac_id')
                ->on('api_cates')
                ->onUpdate('cascade')  // onUpdate cascade 설정
                ->onDelete('cascade'); // onDelete cascade 설정
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_apis');
    }
};
