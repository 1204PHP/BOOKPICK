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

class UserController extends Controller
{
    // 로그인 화면 이동
    public function getLogin() {
        if(Auth::check()) {
            return redirect()->route( 'index' );
            Log::debug("### 유저인증 성공 : 메인페이지 이동 ###");
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, index 리다이렉트
        return view( 'user_login' );
        Log::debug("### 유저인증 실패 : 로그인페이지 이동  ###");
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, user_login 페이지 이동
    }

    // 로그인 처리    
    public function postLogin( Request $request ) {   
        
        // // 로그인 시도 5번 제한
        // $maxLoginAttempts = 5;
        // // 계정 잠금 시간 5분
        // $decayMinutes = 5;
        // $throttleKey = $this->limiter()->key($request);
        // if ($this->hasTooManyLoginAttempts($request)) {
        //     $seconds = $this->limiter()->availableIn($throttleKey) / 60;
        //     $minutes = ceil($seconds / 60);
        //     $errorMsg = '로그인 시도가 너무 많습니다. 잠시 후 다시 시도해주세요. ' . $minutes . ' 분 후에 다시 시도할 수 있습니다.';
        //     return view( 'user_login' )->withErrors( $errorMsg );
        // }

        // 로그인 시도 처리

        $result = User::where( 'u_email', $request->u_email )->first();
        // User모델 내 email에서 요청보낸 email로 검색된 결과 중 첫번째 레코드 반환

        if( !$result || !( Hash::check( $request->u_password, $result->u_password ) ) ) {
            $errorMsg = '이메일 주소와 비밀번호를 다시 확인해주세요.';
            return view( 'user_login' )->withErrors( $errorMsg );
        }
        // $result 내 결과 값이 아니거나 Hash처리 유저 입력 비밀번호와 
        // DB저장 비밀번호가 일치하지 않는 경우 에러메세지 생성
        // 리턴 : user_login 페이지 이동 + 에러메세지

        // User 인증
        Auth::login( $result );

        if(Auth::check()) {
            // $this->clearLoginAttempts($request);
            // 정상 로그인 시 로그인 시도 제한 횟수 초기화
            session( $result->only( 'u_id' ) );
            // 세션 내 u_id 데이터 저장
        } else {
            $errorMsg = '로그인에 실패했습니다. 새로고침 후 재로그인 해주세요.';
            return view( 'user_login' )->withErrors( $errorMsg );
        }
        Log::debug("로그인한 유저 이름: " . $result->u_name);
        return redirect()->route( 'index' )->with('userdata', $result);
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
            Log::debug( "### 트랜잭션 시작 ###" );
            // 이메일, 암호화 된 비밀번호, 이름, 생년월일, 
            // 휴대폰 번호, 우편번호, 기본주소, 상세주소
            // DB저장
            $user = User::firstOrNew(['u_email' => $data['u_email']]);
            if (!$user->exists) {
                // 중복된 이메일이 존재하지 않는 경우
                $user->fill($data);
                $user->save();
                Log::debug( "### 회원가입(회원정보 저장) ###" );
            } else {
                // 중복된 이메일이 존재하는 경우
                $errorMsg = '이미 존재하는 이메일 주소입니다.';
                return view('user_register')->withErrors($errorMsg)
                ->withInput($request->except('u_password', 'u_password_confirm'));
            }
            Log::debug( "### 회원가입(회원정보 저장) 완료 ###" );
            DB::commit();
            Log::debug( "### 커밋 완료 ###" );
            // 회원가입 처리 성공 시 로그인 페이지로 이동
            return redirect()->route( 'getLogin' );    
        } catch(Exception $e) {
            DB::rollback();
            Log::debug( "### 예외발생 : 롤백완료 ###" );
            $errorMsg = '회원가입에 실패했습니다. 새로고침 후 재가입 해주세요';
            return redirect()->route( 'getRegister' )->withErrors( $errorMsg );
        } finally {
            Log::debug( "### 회원가입(회원정보 저장) 종료 ###" );
        }
    }

    // 회원가입 시 이메일 중복체크(api)
    public function confirmEmail(Request $request) {
        $userEmail = $request->input('u_email');
        Log::debug("유저입력 회원가입요청 이메일 : ". $userEmail);
        // DB 중복 이메일 체크
        $confirmEmail = User::withTrashed()->where('u_email', $userEmail)->count();
        if(($confirmEmail=== 1)) {
            $confirmEmail = 1;
            // DB 저장 이메일 존재 시 1 리턴
        } else {
            $confirmEmail = 0;
            // DB 저장 이메일 미존재 시 0 리턴
        }
        Log::debug("DB저장 이메일 확인(존재 1, 미존재 0) : " . $confirmEmail);
        return response()->json(['confirmEmail' => $confirmEmail]);
    }

    // 로그아웃 처리
    public function getLogout() {
        Auth::logout(); 
        // 로그아웃
        Session::flush(); 
        // 세션파기
        return redirect()->route( 'index' );
        // 리턴 : 로그아웃 시 / 리다이렉트
    }

    // 회원정보 수정 전 유저 비밀번호 확인 화면 이동
    public function getPasswordReconfirm() {
        if(!Auth::check()) {
            return redirect()->route('index');
        }        
        return view('user_password_reconfirm');
        // 리턴 : 유저 인증 체크하여 유저일 시, user_password_reconfirm 페이지 이동
    }

    // 회원정보 수정 전 유저 비밀번호 확인 화면 이동
    public function postPasswordReconfirm(Request $request) {
        
        // 빈 값 체크
        if (empty($request->u_password)) {
            $errorMsg = '비밀번호를 입력해주세요';
            Log::debug("### 비밀번호 빈 값입력으로 비밀번호 입력 메세지 출력");
            return view('user_password_reconfirm')->withErrors($errorMsg);
        }

        Log::debug("### 유저의 비밀번호 입력 값 : ". $request->u_password);
        $loginUser = User::where('u_email', Auth::user()->u_email)->first();
    
        if ($loginUser === null) {
            $errorMsg = '비밀번호를 다시 확인해주세요';
            Log::debug("### 비밀번호 null : 비밀번호재확인 메세지 출력");
            return view('user_password_reconfirm')->withErrors($errorMsg);
        } else if (!Hash::check($request->u_password, $loginUser->u_password)) {
            $errorMsg = '비밀번호를 다시 확인해주세요';
            Log::debug("### 비밀번호 불일치 : 비밀번호재확인 메세지 출력");
            return view('user_password_reconfirm')->withErrors($errorMsg);
        } else {
            Log::debug("### 비밀번호 일치 회원정보 수정 페이지로 이동");
            return redirect()->route('getInfo');
        }
    }

    // 회원정보 수정 화면 이동
    public function getInfo() {
        if(Auth::check()) {
            // 현재 로그인한 유저 정보 획득
            $user = Auth::user();
            return view('user_info')->with('userdata',$user);
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, user_info 리다이렉트
        return redirect()->route( 'index' );
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, home 페이지 이동
    }

    // 회원정보 수정 처리
    public function putInfo(Request $request) {
        // 로그인User 수정User 일치여부 확인
        $loginUser = Auth::user();
        if ( !$loginUser ) {
            Log::debug("### 로그인 유저X : 로그인 페이지로 이동 ###");
            return redirect()->route( 'getLogin' );
        }
        // 리턴 : 유저 체크하여 일치하지 않을 시, user_login 리다이렉트

        // 요청한 데이터 중 변경된 데이터 추출
        $requestData = $request->only('new_password', 'password_confirm' ,'u_postcode', 'u_basic_address', 'u_detail_address');
        
        // 변경된 데이터가 있는 경우
        $newRequestData = [];

        // 비밀번호 변경 - 새 비밀번호 암호화처리
        if (!empty($requestData['new_password']) && !empty($requestData['password_confirm'])) {
            // 새 비밀번호와 재확인 비밀번호 일치 확인
            if ($requestData['new_password'] !== $requestData['password_confirm']) {
                $errorMsg = '비밀번호를 다시 확인해주세요';
                Log::debug( "### 변경할 비밀번호 불일치 : 비밀번호 재확인 메세지 출력 ###" );
                return redirect()->route('getInfo')->withErrors($errorMsg);
            }

            // 유저가 입력한 새로운 비밀번호를 암호화하여 저장
            $NewPassword = Hash::make($requestData['new_password']);

            // 새 비밀번호와 현재 비밀번호가 동일한지 확인
            if (Hash::check($requestData['new_password'], $loginUser->u_password)) {
                $errorMsg = '현재 사용 중인 비밀번호와 동일한 비밀번호로 변경할 수 없어요';
                Log::debug("### DB저장 비밀번호와 동일 : 동일한 비밀번호 변경 메시지 출력 ###");
                return redirect()->route('getInfo')->withErrors($errorMsg);
            }

            // 사용자가 입력한 새로운 비밀번호를 암호화하여 저장
            $newRequestData['u_password'] = $NewPassword;
            Log::debug( "### 변경할 비밀번호 암호화 처리 완료 ###" );
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
            session()->flash('infoUpdate', '회원정보가 성공적으로 수정되었습니다');
            return redirect()->route('getInfo');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug( "### 예외발생 : 롤백완료 ###" );
            $errormsg = '회원 정보 수정에 실패했습니다. 새로고침 후 다시 수정 해주세요';
            return redirect()->route('getInfo')->withErrors($errorMsg);
        } finally {
            Log::debug( "### 회원정보 수정 종료 ###" );
        }
    }

    // 회원탈퇴 화면 이동
    public function getWithdrawal() {
        if(Auth::check()) {
            return view( 'user_withdrawal' );
        }
        // 리턴 : 유저 인증 체크하여 유저일 시, user_withdrawal 리다이렉트
        return redirect()->route( 'index' );
        // 리턴 : 유저 인증 체크하여 유저가 아닐 시, home 페이지 이동
    }

    // 회원탈퇴 처리
    public function deleteWithdrawal(Request $request) {
        // 로그인 User 정보 확인
        $loginUser = Auth::user();
        
        Log::debug("### 회원탈퇴 시작 ###");
        try {
            DB::beginTransaction();
            Log::debug("### 트랜잭션 시작 ###");

            $loginUser->delete();
            // 사용자 계정 소프트 삭제(users 테이블)

            $loginUser->user_library()->delete();
            // u_id 연결된 외래키 사용하는 user_library 테이블 softdelete처리
            Log::debug("### user_library 데이터 softdelete 처리성공 ###");

            $loginUser->user_wishlist()->delete();
            // u_id 연결된 외래키 사용하는  user_wishlist 테이블 softdelete처리
            Log::debug("### user_wishlist 데이터 softdelete 처리성공 ###");

            $loginUser->book_detail_comment()->delete();
            // u_id 연결된 외래키 사용하는  book_detail_comment 테이블 softdelete처리
            Log::debug("### book_detail_comment 데이터 softdelete 처리성공 ###");

            DB::commit();
            Log::debug("### 커밋 완료 ###");

            // 로그아웃
            Auth::logout();
            Log::debug("### 로그아웃 ###");

            return redirect()->route('index');
        } catch (Exception $e) {
            DB::rollback();
            Log::debug("### 예외발생 : 롤백완료 ###" . $e->getMessage());
            $errorMsg = '회원 탈퇴에 실패했습니다. 새로고침 후 다시 시도해주세요.';
            return redirect()->back()->withErrors([$errorMsg]);
            // 회원탈퇴 실패 시 회원탈퇴 페이지에 그대로 남아있음
        } finally {
            Log::debug("### 회원탈퇴 종료 ###");
        }
    }

    // 나의 서재 페이지 이동 처리
    public function getLibrary() {
    // 로그인 상태 확인
    if (auth::check()) {
        // 로그인 시 나의 서재 페이지로 이동
        return view('user_library');
    }

    // 비로그인 시 로그인 페이지로 이동
    return redirect()->route('getLogin');

    }
}

