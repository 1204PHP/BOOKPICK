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
        Schema::create('book_api', function (Blueprint $table) {
            
            $table->id('ba_id');
            // 책 api PK
            // default : big_int, pk, auto_increment

            $table->integer('ba_num', 5);
            // api 번호
            // integer 생성(5) / default : not null

            $table->integer('ba_rank', 10)->nullable();
            // api 번호
            // integer 생성(10) / default : nullable

            $table->dateTime('ba_at')->default(now());
            // api 호출일자
            // datetime 생성 / default : now

            // ### 참고사항 ###
            // 예전의 일부 데이터베이스 시스템에서는 INT(5)와 같은 형태로 숫자를 지정하여 자리수를 조절할 수 있었습니다. 
            // 그러나 현대의 대부분의 데이터베이스 시스템에서는 INT 형식의 길이 지정이 무시되며, 
            // 일반적으로 INT는 4바이트로 고정되어 있습니다.
            // 따라서 Laravel에서 integer를 사용할 때는 길이 지정을 하지 않는 것이 좋습니다. 
            // 길이를 지정하면 코드가 더 이해하기 어렵고, 불필요한 부분일 수 있습니다. 
            // $table->integer('ba_num');
            // $table->integer('ba_rank')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_api');
    }
};
