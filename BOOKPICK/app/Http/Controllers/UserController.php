<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    public function getLogin() {
        if(Auth::check()) {
            return redirect()->route( 'main_home' );
        }
        // 유저 인증 체크하여 유저일 시, main_home 리다이렉트
        return view( 'user_login' );
        // 유저 인증 체크하여 유저가 아닐 시, user_login 리턴
    }

    public function postLogin( Request $request ) {
        $result = User::where( 'email', $request->email )->first();
        // User모델 내 email에서 요청보낸 email로 검색된 결과 중 첫번째 레코드 반환
        if( !$result || !( Hash::check( $request->password, $result->password ) ) ) {
            $error_msg = '이메일 또는 비밀번호를 다시 확인해주세요.';
            return view( 'user_login' )->withErrors( $error_msg );
        }
        // $result 내 결과 값이 아니거나 hash 처리 된 유저 입력 비밀번호와 DB저장 비밀번호가 
        // 일치하지 않는 경우 에러메세지 생성
        // user_login + 에러메세지 리턴
        
        Auth::login( $result );
        if(Auth::check()) {
            session( $result->only( 'id' ) );
        } else {
            $error_msg = '인증 에러가 발생했습니다.';
            return view( 'user_login' )->withErrors( $error_msg );
        }
        return redirect()->route( 'main_home' );
    }
}
