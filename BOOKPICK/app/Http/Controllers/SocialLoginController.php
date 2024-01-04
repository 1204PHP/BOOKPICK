<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SocialLoginController extends Controller
{
    public function loginKakao()
    {
        return Socialite::driver('kakao')
            ->with(['prompt' => 'consent'])
            ->redirect();
    }

    // 카카오 소셜로그인
    public function handleLoginKakaoCallback()
    {   
        try {
            $kakaoUser = Socialite::driver('kakao')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->user();        
        } catch (Exception $e) {
            return view('user_login');
            Log::debug("카카오 로그인 오류");
        }

        // 카카오 이메일로 사용자 찾기
        $result = User::where('u_email', $kakaoUser->getEmail())->first();

        // 로그인 전 카카오 유저 정보
        Log::debug("로그인 전 카카오 유저 정보: " . $result);

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
        return redirect()->route('home')->with('userdata', $result);
    }
}
