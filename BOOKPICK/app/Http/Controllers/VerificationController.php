<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{   
    // 이메일 검증 화면 이동
    public function getVerification() 
    {
        return view('user_verification');
    }

    // 이메일 검증 링크 발송
    public function sendVerification(Request $request)
    {   
        $userEmail = $request->input('u_email');
        $user = User::where('u_email', $userEmail)->first();
        Log::debug("검증대상 이메일 주소 : " . $userEmail);
        if (!$user) {
            $hash = Str::random(32);
            // 유저입력 이메일 및 해시 remember_token 저장
            $user = User::create([
                'u_email' => $userEmail,
                'u_password' => '임의생성 u!password',
                'u_name' => '임의생성 u!name',
                'u_birthdate' => '11111111',
                'u_tel' => '임의생성',
                'u_postcode' => '00000',
                'u_basic_address' => '임의생성 u!basic!address',
                'remember_token' => json_encode(['u_email' => $userEmail, 'hash' => $hash]),
            ]);
            // 이메일 미존재 회원정보 임시 저장
            Log::debug("이메일 미존재-회원정보 임시저장 : " . $user);
            $verificationLink = URL::temporarySignedRoute(
                'verifyEmail',
                now()->addMinutes(60), // 만료 시간을 조절할 수 있습니다.
                [
                    'email' => $userEmail,
                    'hash' => $hash,
                ]
            );
            // 생성된 링크를 이용하여 이메일 발송
            Mail::to($userEmail)->send(new VerificationEmail($verificationLink));
            
            return view('user_verification');
        } else {
            // 이미 등록된 이메일일 시 로그인 페이지로 이동
            return redirect()->route('getLogin');
        }
    }

    // 이메일 검증 핸들러
    public function verifyEmail(Request $request, $userEmail)
    {           
        // remember_token에서 이메일과 해시 값을 가져옴
        $userData = json_decode(User::where('u_email', $userEmail)->value('remember_token'), true);
        Log::debug("저장된 remember_token : " . json_encode($userData));
        Log::debug("이메일 검증 시도 유저이메일 : " . $userData['u_email']);
        if ($userData) {
            // remember_token 확인되면 회원가입 페이지로 이동
            return redirect()->route('getRegister')->with('userData', $userData);
        } else {
            // remember_token이 없거나 일치하지 않으면 로그인 페이지로 이동
            return redirect()->route('getLogin');            
        }
    }

    // 이메일 검증 재발송
    public function reSendVerification(Request $request)
    {
        $userData = json_decode(User::where('u_email', $userEmail)->value('remember_token'), true);

        if ($userData) {
            $user->sendEmailVerificationNotification();
            return back()->with('message', 'Verification link sent!');
        } else {
            // 사용자를 찾을 수 없을 때의 처리 (예: 에러 메시지 출력)
            return back()->with('error', 'User not found!');
        }
    }
}