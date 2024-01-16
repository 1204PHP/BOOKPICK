<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Exception;

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
            // 기존 세션 정보 삭제
            session()->forget('kakaoUser');
            // dd($kakaoUser);

            // 새로운 세션 생성
            session(['kakaoAccessToken' => $kakaoUser->token]);
            session(['kakaoUser' => $kakaoUser]);
        } catch (Exception $e) {
            Log::debug("카카오 로그인 오류");
            $errorMsg = '로그인에 실패했습니다. 새로고침 후 재로그인 해주세요';
            return redirect( 'user_login' )->withErrors( $errorMsg );
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
            session($result->only('u_id'));
            // 세션 내 u_id 데이터 저장
            session(['kakaoAccessToken' => $kakaoUser->token]);
            // 세션 내 토큰 저장
        }
        Log::debug("로그인 후 사용자 정보: " . Auth::user());
        Log::debug("로그인한 카카오 유저 닉네임: " . $result->u_name);
        return redirect()->route('index')->with('kakaoUserData', $result);
    }

    public function logoutKakao()
    {   
        // 세션에 저장된 카카오 토큰 획득
        $kakaoAccessToken = session('kakaoAccessToken');
        // 세션에 저장 
        $kakaoUser = session('kakaoUser');

        // 카카오 로그아웃 API 호출
        try {
            $client = new Client([
                'verify' => false,
                'headers' => [
                    'Authorization' => 'Bearer ' . $kakaoAccessToken,
                ],
            ]);

            $response = $client->post('https://kapi.kakao.com/v1/user/logout', [
                'form_params' => [
                    'target_id_type' => 'user',
                    'target_id' => $kakaoUser->getId(), 
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                // 카카오 로그아웃 성공
                Auth::logout();
                session()->flush();
                return redirect()->route('index');
            } else {
                // 카카오 로그아웃 실패
                Log::error('카카오 로그아웃 API 호출 실패 - 응답 코드: ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {
            // Guzzle 예외 처리
            Log::error('카카오 로그아웃 API 호출 중 Guzzle 예외 발생: ' . $e->getMessage());
        } catch (Exception $e) {
            // 다른 예외 처리
            Log::error('카카오 로그아웃 중 예외 발생: ' . $e->getMessage());
            Auth::logout();
            session()->flush();
            return redirect()->route('index');
        }
    }
}
