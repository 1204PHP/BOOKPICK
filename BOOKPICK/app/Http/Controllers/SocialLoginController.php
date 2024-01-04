<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SocialLoginController extends Controller
{
    public function loginKakao()
    {
        return Socialite::driver('kakao')
            ->with(['prompt' => 'consent'])
            ->redirect();
    }
    // composer require laravel/socialite zoho설치 후 계속 작업하려면 타 pc작업시 설치 후 pc 아이피 카카오에 저장

    // 카카오 소셜로그인
    public function handleLoginKakaoCallback()
    {   
        try {
            $kakaoUser = Socialite::driver('kakao')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->user();        
        } catch (Exception $e) {
            Log::debug("카카오 로그인 오류");
            return view('user_login');
        }

        // 카카오 이메일로 사용자 찾기
        $result = User::where('u_email', $kakaoUser->getEmail())->first();

        // 로그인 전 카카오 유저 정보
        Log::debug("로그인 전 카카오 유저 정보: " . $result);

        // 카카오 로그인 여부 세션 저장
        session(['kakaoLogin' => true]);

        if (!$result) {
            // 카카오 이메일 미존재-회원생성
            $result = User::create([
                'u_email' => $kakaoUser->getEmail(),
                'u_password' => '카카오 임의생성 u!password',
                'u_name' => $kakaoUser->getName(),
                'u_birthdate' => '11111111',
                'u_tel' => '임의생성',
                'u_postcode' => '00000',
                'u_basic_address' => '카카오 임의생성 u!basic!address',
            ]);
            // 이메일 미존재 회원가입 처리
            Log::debug("카카오 이메일 미존재-회원가입 처리 : " . $result);
        } else {
            // 이메일 존재 로그인 처리
            Log::debug("카카오 이메일 존재-로그인 처리");
        }
    
        // User 인증
        Auth::login($result);
        session()->flash('success', '로그인 되었습니다.');
        if(Auth::check()) {
            session( $result->only( 'u_id' ) );
            // 세션 내 u_id 데이터 저장
        }
        Log::debug("로그인 후 사용자 정보: " . Auth::user());
        Log::debug("로그인한 카카오 유저 닉네임: " . $result->u_name);
        return redirect()->route('home')->with('kakaoUserData', $result);
    }

    public function logoutKakao()
    {
        Auth::logout();
        // 로그아웃
        Session::flush();
        // 세션 삭제
        Session::regenerate();
        // 기존 세션 ID를 무효화하고 새로운 세션 ID를 생성

        // 로그아웃 후 홈페이지 또는 원하는 다른 페이지로 리다이렉트
        return redirect()->route('index');    
    }
}
