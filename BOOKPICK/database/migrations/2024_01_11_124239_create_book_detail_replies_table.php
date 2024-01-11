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
        Schema::create('book_detail_replies', function (Blueprint $table) {
            $table->id('bdr_id');
            // 책 상세 댓글 PK
            // default : big_int, pk, auto_increment

            $table->string('bdr_comment', 1000);
            // 댓글 내용
            // varchar 생성(1000) / default : not null
            $table->timestamps();
            // created_at, updated_at 라라벨 내부 설정 값으로 자동 생성 / default : null
            
            $table->softDeletes();
            // deleted_at 라라벨 내부 설정 값으로 자동 생성 / default : nullable
            
            $table->unsignedBigInteger('bdc_id');
            $table->foreign('bdc_id')
                ->references('bdc_id')
                ->on('book_detail_comments')
                ->onUpdate('cascade')  // onUpdate cascade 설정
                ->onDelete('cascade'); // onDelete cascade 설정
                
                $table->unsignedBigInteger('u_id');
                $table->foreign('u_id')
                    ->references('u_id')
                    ->on('users')
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
        Schema::dropIfExists('book_detail_replies');
    }
};
