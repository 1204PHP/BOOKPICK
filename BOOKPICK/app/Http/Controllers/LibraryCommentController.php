<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User_library_comment;
use Exception;

class LibraryCommentController extends Controller
{
    // 나의 서재 도서 상세 화면 이동
    public function index() {

        $loginUser = Auth::user();
        if ( !$loginUser ) {
            return redirect()->route( 'getLogin' );
        }








        if(!Auth::check()) {
            return view( 'user_login' );
        }
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, user_login 페이지 이동

        // 게시글 획득
        $result = User_library_comment::limit(3)->orderBy('ulc_id', 'desc')->get();

        return view('user_library_detail')->with('data', $result);
    }

    public function create() {

    }

    public function store(Request $request) {
        if(!Auth::check()) {
            return view( 'user_login' );
        }
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, user_login 페이지 이동

        // 독서기록 작성 처리
        $lcInputData = $request->only('ulc_comment');
        // 독서기록 insert 진행
        Log::debug( "### 독서기록 저장 처리 시작 ###" );
        try {
            DB::beginTransaction();
            Log::debug( "### 트랜잭션 시작 ###" );
            // 독서기록 DB저장
            $lcResult = new User_library_comment($lcInputData);
            $lcResult->save();
            Log::debug( "### 독서기록 저장 완료 ###" );
            DB::commit();
            Log::debug( "### 커밋 완료 ###" );
            // 독서기록 저장 처리 성공 시 나의 도서 상세 페이지로 이동
            return redirect()->route( 'lcDetailIndex' );
        } catch (Exception $e) {
            DB::rollback();
            Log::debug( "### 예외발생 : 롤백완료 ###" );
            $errorMsg = '기록 작성에 실패했습니다. 새로고침 후 재작성 해주세요.';
            return redirect()->route( 'lcDetailIndex' )->withErrors( $errorMsg );
        } finally {
            Log::debug( "### 독서기록 저장 처리 종료 ###" );
        }
    }

    public function show($id) {
       //        
    }

    public function edit($id) {

    }
    
    public function update(Request $request, $id)
    {   
        if(!Auth::check()) {
            return view( 'user_login' );
        }
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, user_login 페이지 이동
        
        Log::debug( "### 독서기록 수정 처리 시작 ###" );
        try {
            DB::beginTransaction();
            Log::debug( "### 트랜잭션 시작 ###" );
            $lcResult = User_library_comment::find($id);
            $lcResult->ulc_comment = $request->ulc_comment;
            $lcResult->save();
            Log::debug( "### 독서기록 수정 완료 ###" );
            DB::commit();
            Log::debug( "### 커밋 완료 ###" );
        } catch (Exception $e) {
            DB::rollback();
            Log::debug( "### 예외발생 : 롤백완료 ###" );
            $errorMsg = '기록 수정에 실패했습니다. 새로고침 후 재작성 해주세요.';
            return redirect()->route( 'lcDetailIndex' )->withErrors( $errorMsg );
        } finally {
            Log::debug( "### 독서기록 수정 처리 종료 ###" );
        }
    }

    public function destroy($id) {
        if(!Auth::check()) {
            return view( 'user_login' );
        }
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, user_login 페이지 이동

        Log::debug( "### 독서기록 삭제 처리 시작 ###" );
        try {
            DB::beginTransaction();
            Log::debug( "### 트랜잭션 시작 ###" );
            Board::destroy($id);
            Log::debug( "### 독서기록 삭제 완료 ###" );
            DB::commit();
            Log::debug( "### 커밋 완료 ###" );
            return redirect()->route( 'lcDetailIndex' );     
        } catch(Exception $e) {
            DB::rollback();
            Log::debug( "### 예외발생 : 롤백완료 ###" );
            $errorMsg = '기록 삭제에 실패했습니다. 새로고침 후 다시 삭제해주세요.';
            return redirect()->route('error')->withError( $errorMsg );
        } finally {
        Log::debug( "### 독서기록 삭제 처리 종료 ###" );
        }
    }
}
