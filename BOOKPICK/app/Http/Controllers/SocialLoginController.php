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
        return Socialite::driver('kakao')->redirect();
    }

    public function handleLoginKakaoCallback()
    {   
        $kakaoUser = Socialite::driver('kakao')
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->user();
        // 카카오 이메일로 사용자 찾기
        $result = User::where('u_email', $kakaoUser->getEmail())->first();

        // 로그인 전 카카오 유저 정보
        Log::debug("로그인 전 카카오 유저 정보: " . json_encode($result));

        if (!$result) {
            // 카카오 이메일 미존재-회원생성
            $result = User::create([
                'u_email' => $kakaoUser->getEmail(),
                'u_password' => 'kakao1',
                'u_name' => $kakaoUser->getName(),
                'u_birthdate' => '11111111',
                'u_tel' => 'kakao3',
                'u_postcode' => '11111',
                'u_basic_address' => 'kakao5',
            ]);
            // 회원 생성
            Log::debug("카카오 이메일 미존재-회원생성 : " . json_encode($result));
        } else {
            // 카카오 이메일 존재-회원생성요청 중복
            Log::debug("카카오 이메일 존재-회원생성요청 중복 : " . json_encode($result));
        }
    
        // User 인증
        Auth::login($result);
        Log::debug("로그인 후 사용자 정보: " . json_encode(Auth::user()));
        Log::debug("로그인한 카카오 유저 닉네임: " . $result->u_name);
        return redirect()->route('home')->with('userdata', $result);
    }
}
