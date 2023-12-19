<?php

namespace App\Http\Controllers;

use Exception;
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
        Log::debug('##### 로그인 포스트 시작 #####');
        // 로그인 시도 5번 제한
        $maxLoginAttempts = 5;
        // 계정 잠금 시간 5분
        // $decayMinutes = 5;
        // $throttleKey = $this->throttleKey($request);
        // if ($this->hasTooManyLoginAttempts($request)) {
        //     $seconds = $this->limiter()->availableIn($throttleKey) / 60;
        //     $minutes = ceil($seconds / 60);
        //     $errorMsg = '로그인 시도가 너무 많습니다. 잠시 후 다시 시도해주세요. ' . $minutes . ' 분 후에 다시 시도할 수 있습니다.';
            
        //     throw ValidationException::withMessages([$this->username() => $errorMsg]);
        // }
        // Log::debug('계정잠금 처리');

        // 로그인 시도 처리

        $result = User::where( 'u_email', $request->u_email )->first();
        Log::debug('셀렉트');
        // User모델 내 email에서 요청보낸 email로 검색된 결과 중 첫번째 레코드 반환

        if( !$result || !( Hash::check( $request->u_password, $result->u_password ) ) ) {
            $errorMsg = '이메일 주소 또는 비밀번호를 다시 확인해주세요.';
            return view( 'user_login' )->withErrors( $errorMsg );
        }
        Log::debug('정상');
        // $result 내 결과 값이 아니거나 Hash처리 유저 입력 비밀번호와 
        // DB저장 비밀번호가 일치하지 않는 경우 에러메세지 생성
        // 리턴 : user_login 페이지 이동 + 에러메세지

        // User 인증
        Auth::login( $result );
        Log::debug('로그인 세션');

        if(Auth::check()) {
            $this->clearLoginAttempts($request);
            // 정상 로그인 시 로그인 시도 제한 횟수 초기화
            session( $result->only( 'u_id' ) );
            // 세션 내 u_id 데이터 저장
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
            $user = User::firstOrNew(['u_email' => $data['u_email']]);
            if (!$user->exists) {
                // 중복된 이메일이 존재하지 않는 경우
                $user->fill($data);
                $user->save();
            } else {
                // 중복된 이메일이 존재하는 경우
                $errorMsg = '이미 존재하는 이메일 주소입니다.';
                return redirect()->route('getRegister')->withErrors($errorMsg);
            }
            Log::debug( "### 회원가입(회원정보 저장) 완료 ###" );
            DB::commit();
            Log::debug( "### 커밋 완료 ###" );
            // 회원가입 처리 성공 시 로그인 페이지로 이동
            return redirect()->route( 'getLogin' );    
        } catch(Exception $e) {
            DB::rollback();
            Log::debug( "# 예외발생 : 롤백완료 #" );
            $errorMsg = '회원가입에 실패했습니다. 새로고침 후 재가입 해주세요.';
            return redirect()->route( 'getRegister' )->withErrors( $errorMsg );
        } finally {
        Log::debug( "# 회원가입(회원정보 저장) 종료 #" );
        }
    }

    // 로그아웃 처리
    public function getLogout() {
        Auth::logout(); 
        // 로그아웃
        $request->session()->invalidate();
        // 현재 세션 무효화 : 현재 user 세션 파기, 새로운 세션 생성
        $request->session()->regenerateToken();
        // CSFR토큰 재생성 : 로그아웃 후 새로운 토큰 생성하여 이전 토큰 또는 요청 사용불가 하도록 처리
        return redirect()->route( 'index' );
        // 리턴 : 로그아웃 시 / 리다이렉트
    }

    // 회원정보 수정 화면 이동
    public function getInfo() {
        if(Auth::check()) {
            return redirect()->route( 'getInfo' );
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, user_info 리다이렉트
        return redirect()->route( 'index' );
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, home 페이지 이동
    }

    // 회원정보 수정 처리
    public function putInfo(Request $request, $id)
    {
        // 로그인User 수정User 일치여부 확인
        $loginUser = Auth::user();
        if ( $loginUser->id != $id ) {
            return redirect()->route( 'getLogin' );
        }
        // 리턴 : 유저 체크하여 일치하지 않을 시, user_login 리다이렉트

        // 현재 비밀번호 확인 및 새 비밀번호 암호화
        $currentPassword = $loginUser->u_password;

        // 요청한 데이터 중 변경된 데이터 추출
        $requestData = $request->only('u_password', 'u_postcode', 'u_basic_address', 'u_detail_address');

        // 변경된 데이터가 없는 경우
        if (empty(array_filter($requestData))) {
            return redirect()->route('getInfo', ['user' => $id]);
        }
        
        // 변경된 데이터가 있는 경우
        $newRequestData = [];

        // 비밀번호 변경 - 현재 비밀번호 확인 후 암호화처리
        if (!empty($requestData['u_password'])) {
            if (Hash::check($requestData['u_password'], $currentPassword)) {
                $newRequestData['u_password'] = Hash::make($requestData['u_password']);
            } else {
                // 현재 비밀번호가 일치하지 않으면 리다이렉트
                return redirect()->route('getInfo', ['user' => $id]);
            }
        }

        // 비밀번호 제외 다른 데이터 변경 처리
        foreach (['u_postcode', 'u_basic_address', 'u_detail_address'] as $field) {
            if (array_key_exists($field, $requestData)) {
                $newRequestData[$field] = $requestData[$field];
            }
        }

        // 회원정보 수정 진행
        Log::debug( "### 회원정보 수정 시작 ###" );
        try {
            DB::beginTransaction();
            Log::debug( "### 트랜잭션 시작 ###" );
            $loginUser->update($newRequestData);
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

    // 회원탈퇴 화면 이동
    public function getWithdrawal() {
        if(Auth::check()) {
            return redirect()->route( 'getWithdrawal' );
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, user_withdrawal 리다이렉트
        return redirect()->route( 'index' );
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, home 페이지 이동
    }

    // 회원탈퇴 처리
    public function postWithdrawal(Request $request)
    {
        // 로그인한 User 확인
        $loginUser = Auth::user();
        
        Log::debug("### 회원탈퇴 시작 ###");
        try {
            DB::beginTransaction();
            Log::debug("### 트랜잭션 시작 ###");

            // 유저 계정 삭제
            $loginUser->delete();

            DB::commit();
            Log::debug("### 커밋 완료 ###");

            // 로그아웃
            Auth::logout();

            // 세션 파기
            $request->session()->invalidate();
            // 현재 세션 무효화 : 현재 user 세션 파기, 새로운 세션 생성
            $request->session()->regenerateToken();
            // CSFR토큰 재생성 : 로그아웃 후 새로운 토큰 생성하여 이전 토큰 또는 요청 사용불가 하도록 처리
            
            return redirect()->route( 'index' );
            // 회원탈퇴 성공 시 메인 페이지로 리다이렉트
        } catch (Exception $e) {
            DB::rollback();
            Log::debug("# 예외발생 : 롤백완료 #");
            $errorMsg = '회원 탈퇴에 실패했습니다. 새로고침 후 다시 시도해주세요.';
            return redirect()->back()->withErrors([$errorMsg]);
            // 회원탈퇴 실패 시 회원탈퇴 페이지에 그대로 남아있음
        } finally {
            Log::debug("# 회원탈퇴 종료 #");
        }
    }
}

