<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Faker\Factory as Faker;

class AdminController extends Controller
{
    public function index()
    {
        $bookTableColumn = DB::getSchemaBuilder()->getColumnListing("book_infos");
        $bookTableData = DB::table('book_infos')->orderBy('b_id')->Paginate(10);
        return view( 'admin' )
            ->with('bookTableColumn', $bookTableColumn)
            ->with('bookTableData', $bookTableData);
    }
    public function postAdminBook()
    {
        try {
        $Faker = Faker::create();
        $apiUrl = 'http://www.aladin.co.kr/ttb/api/ItemList.aspx?ttbkey=ttbckstjddh11142001&QueryType=Bestseller&MaxResults=50&start=1&SearchTarget=Book&output=JS&Version=20131101&cover=big';
        $response = Http::get($apiUrl);
        $responseData = $response->json();

        Log::debug("----------DB 책 정보 INSERT 시작-----------");
        foreach ($responseData['item'] as $val) {
            $resultdata = [
                'b_ISBN' => $val['isbn'],
                'b_price' => $val['priceStandard'],
                'b_title' => $val['title'],
                'b_author' => $val['author'],
                'b_summary' => $val['description'],
                'b_main_cate' => $val['categoryName'],
                'b_sub_cate' => $val['categoryName'],
                'b_publication_date' => $val['pubDate'],
                'b_publisher' => $val['publisher'],
                'b_img_url' => $val['cover'],
                'b_product_url' =>$val['link'],
            ];
            $existingRecord = DB::table('book_infos')->where('b_isbn', $resultdata['b_ISBN'])->first();
            if(!$existingRecord) {
                DB::table('book_infos')->insert( $resultdata );
                Log::debug('책 삽입 성공  ISBN:' . $resultdata['b_ISBN']);
            } else {
                Log::debug('해당 ISBN이 존재 ISBN:' . $resultdata['b_ISBN']);
            }

            /**
             * book_apis 데이터 삽입처리 작성
             */
            
        }
        Log::debug("----------DB 책 정보 INSERT 끝-----------");
        return redirect()->route('getadmin');
        } catch (\Exception $e) {
            Log::error('Error message: ' . $e->getMessage());
            return redirect()->route('getadmin');
        }
    }
}
