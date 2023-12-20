<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
// use Faker\Factory as Faker;

class AdminController extends Controller
{
    public function index()
    {
        $bookTableColumn = DB::getSchemaBuilder()->getColumnListing("book_infos");
        $bookTableData = DB::table('book_infos')->orderBy('b_id')->paginate(10, ['*'], 'book_info_page');
        $apiCateTableColumn = DB::getSchemaBuilder()->getColumnListing("api_cates");
        $apiCateTableData = DB::table('api_cates')->orderBy('ac_id')->paginate(10, ['*'], 'api_cate_page');
        $bookApiTableColumn = DB::getSchemaBuilder()->getColumnListing("book_apis");
        $bookApiTableData = DB::table('book_apis')->orderBy('ba_id', 'desc')->paginate(10, ['*'], 'book_api_page');
        
        return view( 'admin' )
            ->with('bookTableColumn', $bookTableColumn)
            ->with('bookTableData', $bookTableData)
            ->with('apiCateTableColumn', $apiCateTableColumn)
            ->with('apiCateTableData', $apiCateTableData)
            ->with('bookApiTableColumn', $bookApiTableColumn)
            ->with('bookApiTableData', $bookApiTableData);
    }
    public function adminBookInfo( Request $request)
    {
        try {
            // $Faker = Faker::create();
            $apiUrl = 'http://www.aladin.co.kr/ttb/api/ItemList.aspx?ttbkey=ttbckstjddh11142001&QueryType=Bestseller&MaxResults=50&start=1&SearchTarget=Book&output=JS&Version=20131101&cover=big';
            $response = Http::get($apiUrl);
            $responseData = $response->json();
            $apiCateInput = $request->input('ApiCateInput');

            Log::debug("----------DB BookInfo INSERT 시작-----------");
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

            }
            Log::debug("----------DB BookInfo INSERT 끝-----------");

            Log::debug("----------DB BookApi INSERT 시작-----------");
            foreach ($responseData['item'] as $val) {
                if(array_key_exists('bestRank', $val)) {
                    $newData = $val['bestRank'];
                }
                else {
                    $newData = NULL;
                }
                $bIdData = DB::table('book_infos')->where('b_isbn', $val['isbn'])->first();

                $resultdata = [
                    'ba_rank' => $newData,
                    'b_id' => $bIdData -> b_id,
                    'ac_id' => $apiCateInput
                ];
                DB::table('book_apis')->insert( $resultdata );
                Log::debug('BookApi 책 삽입 성공 b_id:' . $resultdata['b_id']);
            }
            Log::debug("----------DB BookApi INSERT 끝-----------");
            return redirect()->route('getAdmin');
        } catch (\Exception $e) {
            Log::error('postAdminBookInfo Error message: ' . $e->getMessage());
            return redirect()->route('getAdmin');
        }
    }
    public function adminApiCate( Request $request)
    {
        try {
            $result = $request->input('ApiCateInput');
            Log::debug("----------DB ApiCate 정보 INSERT 시작-----------");

            DB::table('api_cates')->insert([
                'ac_name' => $result
            ]);
            Log::debug("----------DB ApiCate 정보 INSERT 끝-----------");
            return redirect()->route('getAdmin');
        }
        catch (\Exception $e) {
            Log::error('postAdminApiCate Error message: ' . $e->getMessage());
            return redirect()->route('getAdmin');
        }
    }
}
