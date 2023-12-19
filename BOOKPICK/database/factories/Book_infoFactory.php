<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use App\Models\Book_info;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book_info>
 */
class Book_infoFactory extends Factory
{
    protected $model = Book_info::class;

    public function definition()
    {
        // $apiUrl = 'http://www.aladin.co.kr/ttb/api/ItemList.aspx?ttbkey=ttbckstjddh11142001&QueryType=Bestseller&MaxResults=10&start=1&SearchTarget=Book&output=JS&Version=20131101';
        // $response = Http::get($apiUrl);
        // $responseData = $response->json();
        
        // Log::debug("----------DB 책 정보 INSERT 시작-----------");
        // foreach ($responseData['item'] as $val) {
        //     Log::debug($val['title']);
        //     $resultdata = [
        //         'b_ISBN' => $this->faker->name,
        //         'b_price' => $this->faker->randomNumber(1),
        //         'b_ISBN' => $this->faker->name,
        //         'b_title' => $val['title'],
        //         'b_author' => $this->faker->name,
        //         'b_summary' => $this->faker->name,
        //         'b_main_cate' => $this->faker->name,
        //         'b_sub_cate' => $this->faker->name,
        //         'b_publication_date' => now(),
        //         'b_publisher' => $this->faker->name,
        //         'b_img_url' => $this->faker->name,
        //         'b_product_url' => $this->faker->name,
        //     ];
        //     DB::table('book_infos')->insert( $resultdata );
        // }
        // Log::debug("----------DB 책 정보 INSERT 끝-----------");
    }
}
