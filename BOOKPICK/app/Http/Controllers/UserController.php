<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getLogin() {
        if(Auth::check()) {
            return redirect()->route( 'index' );
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, index 리다이렉트
        return view( 'user_login' );
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, user_login 페이지 이동
    }

    public function postLogin( Request $request ) {
        $result = User::where( 'u_email', $request->u_email )->first();
        // User모델 내 email에서 요청보낸 email로 검색된 결과 중 첫번째 레코드 반환
        if( !$result || !( Hash::check( $request->u_password, $result->u_password ) ) ) {
            $error_msg = '이메일 또는 비밀번호를 다시 확인해주세요.';
            return view( 'user_login' )->withErrors( $error_msg );
        }
        // $result 내 결과 값이 아니거나 Hash처리 유저 입력 비밀번호와 
        // DB저장 비밀번호가 일치하지 않는 경우 에러메세지 생성
        // 리턴 : user_login 페이지 이동 + 에러메세지
        
        Auth::login( $result );
        if(Auth::check()) {
            session( $result->only( 'u_id' ) );
        } else {
            $error_msg = '인증 에러가 발생했습니다.';
            return view( 'user_login' )->withErrors( $error_msg );
        }
        return redirect()->route( 'index' );
    }

    public function getRegister() {
        return view( 'user_register' );
    }

    public function postRegister( Request $request ) {        
        $data = $request->only('u_email', 'u_password', 'u_name', 'u_birthdate',
        'u_tel', 'u_postcode', 'u_basic_address', 'u_detail_address');
        // DB저장데이터(이메일, 비밀번호, 이름, 생년월일, 
        // 휴대폰 번호, 우편번호, 기본주소, 상세주소) 획득
        $data['u_password'] = Hash::make( $data['u_password'] );
        // Hash처리 비밀번호 암호화
        Log::debug( "# 회원가입(회원정보 저장) 시작 # " );
        try {
            DB::beginTransaction();
            Log::debug( "# 트랜잭션 시작 #" );
            $result = User::create( $data );
            // 이메일, 암호화 된 비밀번호, 이름, 생년월일, 
            // 휴대폰 번호, 우편번호, 기본주소, 상세주소
            // DB저장
            Log::debug( "# 회원가입(회원정보 저장) 완료 #" );
            DB::commit();
            Log::debug( "# 커밋 완료 #" );
            return redirect()->route( 'login' );    
        } catch(Exception $e) {
            DB::rollback();
            Log::debug( "# 예외발생 : 롤백완료 #" );
            $errormsg = '회원가입에 실패했습니다. 고객센터 문의바랍니다.';
            return redirect()->route( 'error' )->withError( $errormsg );
        } finally {
        Log::debug( "# 회원가입(회원정보 저장) 종료 #" );
        }
    }

    public function getLogout() {
        Session::flush(); 
        // 세션파기
        Auth::logout(); 
        // 로그아웃
        return redirect()->route( 'index' );
    }

    public function getInfo() {
        if(Auth::check()) {
            return redirect()->route( 'getInfo' );
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, user_info 리다이렉트
        return view( 'home' );
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, home 페이지 이동
    }

    public function putInfoUpdate(Request $request, $id)
    {   
        $data = $request->only('u_password', 'u_postcode', 'u_basic_address', 'u_detail_address');        
        if (isset($data['u_password'])) {
            $data['u_password'] = Hash::make($data['u_password']);
        }
        // $data 내 비밀번호 확인
        // 비밀번호가 있을 때 Hash처리 비밀번호 암호화
        $result = User::find($id);
        // DB저장된 u_id 찾기
        $result->update($data);
        return redirect()->route('getInfo', ['user' => $id]);
    }
    //***********************************업데이트 수정하기 내 깃 라라벨보드 보드컨트롤러 참고 */
}
