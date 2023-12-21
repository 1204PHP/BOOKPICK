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

            // QueryType 종류
            // ItemNewAll : 신간 전체 리스트
            // ItemNewSpecial : 주목할 만한 신간 리스트
            // ItemEditorChoice : 편집자 추천 리스트
            // (카테고리로만 조회 가능 - 국내도서/음반/외서만 지원)
            // Bestseller : 베스트셀러
            // BlogBest : 블로거 베스트셀러 (국내도서만 조회 가능)

            $faker = Faker::create('ko_KR');
            $apiUrl = 'http://www.aladin.co.kr/ttb/api/ItemList.aspx?ttbkey=ttbckstjddh11142001&QueryType=Bestseller&MaxResults=50&start=1&SearchTarget=Book&output=JS&Version=20131101&cover=big';
            // $apiUrl = 'http://www.aladin.co.kr/ttb/api/ItemList.aspx?ttbkey=ttbckstjddh11142001&QueryType=ItemNewAll&MaxResults=50&start=1&SearchTarget=Book&output=JS&Version=20131101&cover=big';
            $response = Http::get($apiUrl);
            $responseData = $response->json();
            $apiCateInput = $request->input('ApiCateInput');
            Log::debug("----------DB BookInfo INSERT 시작-----------");
            foreach ($responseData['item'] as $val) {
                $priceStandard = empty($val['priceStandard']) ? $priceStandard=$faker->$randomNumber(3) : $val['priceStandard'];
                $author = empty($val['author']) ? $faker->name() : $val['author'];
                $description = empty($val['description']) ? $faker->realText(50) : $val['description'];
                $subCate = implode('>', array_slice(explode('>', $val['categoryName']), 0, 2));
                $resultdata = [
                    'b_ISBN' => $val['isbn'],
                    'b_price' => $priceStandard,
                    'b_title' => $val['title'],
                    'b_author' => $author,
                    'b_summary' => $description,
                    'b_main_cate' => $val['categoryName'],
                    'b_sub_cate' => $subCate,
                    'b_publication_date' => $val['pubDate'],
                    'b_publisher' => $val['publisher'],
                    'b_img_url' => $val['cover'],
                    'b_product_url' =>$val['link'],
                    'created_at' => now(),
                    'updated_at' => now(),
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
                    'ac_id' => $apiCateInput,
                    'created_at' => now(),
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
    public function adminApiCateAuto()
    {
        try {
            Log::debug("----------DB ApiCateAuto 정보 INSERT 시작-----------");
            $data = [
                ['ac_name' => '신간 전체 리스트'],
                ['ac_name' => '주목할 만한 신간 리스트'],
                ['ac_name' => '편집자 추천 리스트'],
                ['ac_name' => '베스트셀러'],
                ['ac_name' => '블로거 베스트셀러']
            ];
            DB::table('api_cates')->insert($data);
            Log::debug("----------DB ApiCateAuto 정보 INSERT 끝-----------");
            return redirect()->route('getAdmin');
        }
        catch (\Exception $e) {
            Log::error('ApiCateAuto Error message: ' . $e->getMessage());
            return redirect()->route('getAdmin');
        }
    }
}
