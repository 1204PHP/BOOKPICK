<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use App\Models\Api_cate;
use App\Models\Book_api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function index()
    {
        $bookTableColumn = DB::getSchemaBuilder()->getColumnListing("book_infos");
        $bookTableData = Book_info::orderBy('b_id')->paginate(10, ['*'], 'book_info_page');
        $apiCateTableColumn = DB::getSchemaBuilder()->getColumnListing("api_cates");
        $apiCateTableData = Api_cate::orderBy('ac_id')->paginate(10, ['*'], 'api_cate_page');
        $bookApiTableColumn = DB::getSchemaBuilder()->getColumnListing("book_apis");
        $bookApiTableData = Book_api::orderBy('ba_id', 'desc')->paginate(10, ['*'], 'book_api_page');
        
        return view( 'admin' )
            ->with('bookTableColumn', $bookTableColumn)
            ->with('bookTableData', $bookTableData)
            ->with('apiCateTableColumn', $apiCateTableColumn)
            ->with('apiCateTableData', $apiCateTableData)
            ->with('bookApiTableColumn', $bookApiTableColumn)
            ->with('bookApiTableData', $bookApiTableData);
    }
    public function adminBookInfo( Request $request )
    {
        try {
            $action = $request->input('action');
            switch ($action) {
                case 'ItemNewAll':
                    $QueryType = "ItemNewAll";
                    break;
                case 'ItemNewSpecial':
                    $QueryType = "ItemNewSpecial";
                    break;
                case 'Bestseller':
                    $QueryType = "Bestseller";
                    break;
                case 'BlogBest':
                    $QueryType = "Blogbest";
                    break;
                default:
                    break;
            }
            $cnt=1;
            DB::beginTransaction();
            Log::debug("#트랜잭션 시작");
            for($start=1; $start<=10; $start++) {
                $apiUrl = "http://www.aladin.co.kr/ttb/api/ItemList.aspx?ttbkey=ttbckstjddh11142001&QueryType="
                .$QueryType
                ."&MaxResults=50&start="
                .$start.
                "&SearchTarget=Book&output=JS&Version=20131101&cover=big";
                $response = Http::get($apiUrl);
                $responseData = $response->json();
                Log::debug("----------DB BookInfo INSERT 시작-----------");
                foreach ($responseData['item'] as $val) {
                    $priceStandard = empty($val['priceStandard']) ? "" : $val['priceStandard'];
                    $author = empty($val['author']) ? "" : $val['author'];
                    $description = empty($val['description']) ? "" : $val['description'];
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
                    ];
                    $existingRecord = Book_info::where('b_isbn', $resultdata['b_ISBN'])->first();
                    
                    if(!$existingRecord) {
                        Book_info::create($resultdata);
                        Log::debug($cnt.'-'.$QueryType.' 책 삽입 성공  ISBN:' . $resultdata['b_ISBN']);
                    } else {
                        Log::debug($cnt.'-'.$QueryType.' 해당 ISBN이 존재 ISBN:' . $resultdata['b_ISBN']);
                    }
                    $cnt++;
                }
            }
            DB::commit();
            Log::debug("#트랜잭션 커밋");
            Log::debug("----------DB BookInfo INSERT 끝-----------");
            return redirect()->route('getAdmin');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug("#트랜잭션 롤백");
            Log::error('postAdminBookInfo Error message: ' . $e->getMessage());
            return redirect()->route('getAdmin');
        }
    }
    public function adminBookApi( Request $request)
    {
        try {
            $action = $request->input('action');
            switch ($action) {
                case 'ItemNewAll':
                    $apiCateInput = 1;
                    $QueryType = "ItemNewAll";
                    break;
                case 'ItemNewSpecial':
                    $apiCateInput = 2;
                    $QueryType = "ItemNewSpecial";
                    break;
                case 'Bestseller':
                    $apiCateInput = 3;
                    $QueryType = "Bestseller";
                    break;
                case 'BlogBest':
                    $apiCateInput = 4;
                    $QueryType = "Blogbest";
                    break;
                default:
                    break;
            }

            $apiUrl = "http://www.aladin.co.kr/ttb/api/ItemList.aspx?ttbkey=ttbckstjddh11142001&QueryType="
                    .$QueryType
                    ."&MaxResults=50&start=1&SearchTarget=Book&output=JS&Version=20131101&cover=big";
            $response = Http::get($apiUrl);
            $responseData = $response->json();
            $cnt=1;
            Log::debug("----------DB BookInfo-Api연동 INSERT 시작-----------");
            DB::beginTransaction();
            Log::debug("#트랜잭션 시작");
            foreach ($responseData['item'] as $val) {
                $priceStandard = empty($val['priceStandard']) ? "" : $val['priceStandard'];
                $author = empty($val['author']) ? "" : $val['author'];
                $description = empty($val['description']) ? "" : $val['description'];
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
                    // 'created_at' => now(),
                    // 'updated_at' => now(),
                ];
                $existingRecord = Book_info::where('b_isbn', $resultdata['b_ISBN'])->first();
                if(!$existingRecord) {
                    Book_info::create($resultdata);
                    Log::debug($cnt.'-책 삽입 성공  ISBN:' . $resultdata['b_ISBN']);
                } else {
                    Log::debug($cnt.'-해당 ISBN이 존재 ISBN:' . $resultdata['b_ISBN']);
                }
                $cnt++;
            }
            Log::debug("----------DB BookInfo-Api연동 INSERT 끝-----------");

            Log::debug("----------DB BookApi INSERT 시작-----------");
            $cnt=1;
            foreach ($responseData['item'] as $val) {
                if(array_key_exists('bestRank', $val)) {
                    $newData = $val['bestRank'];
                }
                else {
                    $newData = NULL;
                }
                $bIdData = Book_info::where('b_isbn', $val['isbn'])->first();

                $resultdata = [
                    'ba_rank' => $newData,
                    'b_id' => $bIdData -> b_id,
                    'ac_id' => $apiCateInput,
                    // 'created_at' => now(),
                ];
                Book_api::create($resultdata);
                // DB::table('book_apis')->insert( $resultdata );
                Log::debug($cnt.'-'.$QueryType.'-BookApi 책 삽입 성공 b_id:' . $resultdata['b_id']);
                $cnt++;
            }
            DB::commit();
            Log::debug("#트랜잭션 커밋");
            Log::debug("----------DB BookApi INSERT 끝-----------");
            return redirect()->route('getAdmin');
        } catch (\Exception $e) {
            Log::error( "--------DB adminBookInfo 에러발생---------" );
            DB::rollback();
            Log::debug("#트랜잭션 롤백");
            Log::error('postAdminBookApi Error message: ' . $e->getMessage());
            Log::error( "------------------------------------------" );
            return redirect()->route('getAdmin');
        }
    }
    public function adminApiCate( Request $request)
    {
        try {
            $result = $request->input('ApiCateInput');
            $data = [
                'ac_name' => $result,
            ];
            Log::debug("----------DB ApiCate 정보 INSERT 시작-----------");
            DB::beginTransaction();
            Log::debug("#트랜잭션 시작");

            Api_cate::create($data);
            DB::commit();
            Log::debug("#트랜잭션 커밋");
            Log::debug("----------DB ApiCate 정보 INSERT 끝-----------");
            return redirect()->route('getAdmin');
        }
        catch (\Exception $e) {
            Log::error( "--------DB ApiCate 에러발생---------" );
            DB::rollback();
            Log::debug("#트랜잭션 롤백");
            Log::error('postAdminApiCate Error message: ' . $e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route('getAdmin');
        }
    }
    public function adminApiCateAuto()
    {
        try {
            Log::debug("----------DB ApiCateAuto 정보 INSERT 시작-----------");
            DB::beginTransaction();
            Log::debug("#트랜잭션 시작");
            $data = [
                ['ac_name' => '신간 전체 리스트',
                    'created_at' => now(),
                    'updated_at' => now(),],
                ['ac_name' => '주목할 만한 신간 리스트',
                'created_at' => now(),
                'updated_at' => now(),],
                ['ac_name' => '베스트셀러',
                'created_at' => now(),
                'updated_at' => now(),],
                ['ac_name' => '블로거 베스트셀러',
                'created_at' => now(),
                'updated_at' => now(),],
            ];
            
            Api_cate::insert($data);
            DB::commit();
            Log::debug("#트랜잭션 커밋");
            Log::debug("----------DB ApiCateAuto 정보 INSERT 끝-----------");
            return redirect()->route('getAdmin');
        }
        catch (\Exception $e) {
            Log::error( "--------DB ApiCateAuto 에러발생---------" );
            DB::rollback();
            Log::debug("#트랜잭션 롤백");
            Log::error('ApiCateAuto Error message: ' . $e->getMessage());
            Log::error( "---------------------------------------" );
            return redirect()->route('getAdmin');
        }
    }
}
