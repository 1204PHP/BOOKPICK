<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class UserController extends Controller
{
    // 로그인 화면 이동
    public function getLogin() {
        if(Auth::check()) {
            return redirect()->route( 'index' );
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, index 리다이렉트
        return view( 'user_login' );
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, user_login 페이지 이동
    }

    // 로그인 처리    
    public function postLogin( Request $request ) {   
        
        // ### 로그인 시도에 대한 유효성 검사 ###

        // 로그인 시도 5번 제한
        $maxLoginAttempts = 5;
        // 계정 잠금 시간 60분
        $decayMinutes = 60;
        $throttleKey = $this->throttleKey($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $seconds = $this->limiter()->availableIn($throttleKey);
            $errorMsg = '로그인 시도가 너무 많습니다. 잠시 후 다시 시도해주세요. ' . $seconds . ' 초 후에 다시 시도할 수 있습니다.';

            throw ValidationException::withMessages([
                $this->username() => [$errorMsg],
            ]);
        }

        // ### 로그인 시도 처리

        $result = User::where( 'u_email', $request->u_email )->first();
        // User모델 내 email에서 요청보낸 email로 검색된 결과 중 첫번째 레코드 반환
        if( !$result || !( Hash::check( $request->u_password, $result->u_password ) ) ) {
            $errorMsg = '이메일 주소 또는 비밀번호를 다시 확인해주세요.';
            return view( 'user_login' )->withErrors( $errorMsg );
        }
        // $result 내 결과 값이 아니거나 Hash처리 유저 입력 비밀번호와 
        // DB저장 비밀번호가 일치하지 않는 경우 에러메세지 생성
        // 리턴 : user_login 페이지 이동 + 에러메세지

        // User 인증
        Auth::login( $result );
        if(Auth::check()) {
            $this->cleaLoginAttempts($request);
            // 세션 내 u_id 데이터 저장
            session( $result->only( 'u_id' ) );
        } else {
            $errorMsg = '로그인에 실패했습니다. 새로고침 후 재로그인 해주세요.';
            return view( 'user_login' )->withErrors( $errorMsg );
        }
        return redirect()->route( 'index' );
    }

    // 회원가입 화면 이동
    public function getRegister() {
        return view( 'user_register' );
    }

    // 회원가입 처리
    public function postRegister( Request $request ) {        
        // DB저장데이터(이메일, 비밀번호, 이름, 생년월일, 
        // 휴대폰 번호, 우편번호, 기본주소, 상세주소) 획득
        $data = $request->only('u_email', 'u_password', 'u_name', 'u_birthdate',
        'u_tel', 'u_postcode', 'u_basic_address', 'u_detail_address');
        // Hash처리 비밀번호 암호화
        $data['u_password'] = Hash::make( $data['u_password'] );
        // 회원가입 진행
        Log::debug( "### 회원가입(회원정보 저장) 시작 ###" );
        try {
            DB::beginTransaction();
            Log::debug( "# 트랜잭션 시작 #" );
            // 이메일, 암호화 된 비밀번호, 이름, 생년월일, 
            // 휴대폰 번호, 우편번호, 기본주소, 상세주소
            // DB저장
            $result = User::create( $data );
            Log::debug( "### 회원가입(회원정보 저장) 완료 ###" );
            DB::commit();
            Log::debug( "### 커밋 완료 ###" );
            return redirect()->route( 'getLogin' );    
        } catch(Exception $e) {
            DB::rollback();
            Log::debug( "# 예외발생 : 롤백완료 #" );
            $errorMsg = '회원가입에 실패했습니다. 새로고침 후 재가입 해주세요.';
            return redirect()->route( 'getRegister' )->withError( $errorMsg );
        } finally {
        Log::debug( "# 회원가입(회원정보 저장) 종료 #" );
        }
    }

    // 로그아웃 처리
    public function getLogout() {
        // 세션파기
        Session::flush(); 
        // 로그아웃
        Auth::logout(); 
        return redirect()->route( 'index' );
        // 리턴 : 로그아웃 시 / 리다이렉트
    }

    // 회원정보 수정 화면 이동
    public function getInfo() {
        if(Auth::check()) {
            return redirect()->route( 'getInfo' );
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, user_info 리다이렉트
        return view( 'home' );
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, home 페이지 이동
    }

    // 회원정보 수정 처리
    public function putInfoUpdate(Request $request, $id)
    {
        // 로그인User 수정User 일치여부 확인
        $loginUser = Auth::user();
        if ( $loginUser->id != $id ) {
            return redirect()->route( 'getLogin' );
        }
        // 리턴 : 유저 체크하여 일치하지 않을 시, user_login 리다이렉트

        // 현재 비밀번호 확인 및 새 비밀번호 암호화
        $data = $request->only( 'u_password', 'u_postcode', 'u_basic_address', 'u_detail_address' );
        $data[ 'u_password' ] = Hash::make( $data[ 'u_password' ] );    
        // 회원정보 수정 진행
        Log::debug( "### 회원정보 수정 시작 ###" );
        try {
            DB::beginTransaction();
            Log::debug( "### 트랜잭션 시작 ###" );
            $currentUser->update($data);
            DB::commit();
            Log::debug( "### 커밋 완료 ###" );
            return redirect()->route('getInfo', ['user' => $id]);
        } catch (Exception $e) {
            DB::rollback();
            Log::debug( "# 예외발생 : 롤백완료 #" );
            $errormsg = '회원 정보 수정에 실패했습니다. 새로고침 후 다시 수정 해주세요.';
            return redirect()->route('getInfo', ['user' => $id])->withErrors($errormsg);
        } finally {
            Log::debug( "# 회원정보 수정 종료 #" );
        }
    }
}
