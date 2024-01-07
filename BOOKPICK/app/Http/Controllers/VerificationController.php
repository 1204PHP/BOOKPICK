<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    // 이메일 검증 링크 발송
    public function showVerificationNotice()
    {
        return view('auth.verify-email');
    }

    // 이메일 검증 핸들러
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        event(new Verified($request->user()));

        return redirect()->route( 'home' );
    }

    // 이메일 검증 재발송
    public function resendVerificationNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}