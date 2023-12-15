<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'u_email' => 'required|regex:/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/|unique:user,u_email',
            // 필수입력, RFC5322 표준 정규 표현식
            'u_password' => 'required|string|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$/',
            // 필수입력, 최소 8자 이상, 최소 하나의 문자&하나의 숫자&하나의 특수문자(!@#$%^&*) 포함된 비밀번호 정규 표현식
            'u_name' => 'required|regex:/^[가-힣]{1,50}$/|max:50',
            // 필수입력, 한글이름만 허용, 특수문자&숫자&공백 불허, 최대 50글자 허용
            'u_birthdate' => 'required|regex:/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/',
            // 필수입력, YYYY-MM-DD 허용
            'u_tel' => 'required|regex:/^010[0-9]{3,4}[0-9]{4}$/|max:11',
            // 필수입력, 대한민국 기준 휴대폰 번호 형식만 허용
            'u_postcode' => 'required|regex:/^\d{5}$/|max:6',
            // 필수입력, 대한민국 기준 우편번호 5자리
            'u_basic_address' => 'required',
            // 필수입력
            'u_detail_address' => 'required',
            // 필수입력
        ], $this->errorMsg());

        if ($validator->fails()) {
            $errormsg = $this->errormsg();
            return response()->json(['errors' => $errormsg]);
        }
        return $next($request);
    }

    public function errormsg() {
        return [
            'u_email.required' => '이메일: 필수 정보입니다.',
            'u_email.regex' => '이메일: 올바른 이메일 형식이 아닙니다.',
            'u_email.unique' => '이메일: 이미 사용 중인 이메일입니다.',
            'u_password.required' => '비밀번호: 필수 정보입니다.',
            'u_password.regex' => '비밀번호: 보안강도가 약합니다.',
            'u_name.required' => '이름: 필수 정보입니다.',
            'u_name.regex' => '이름: 한글로만 입력가능 합니다',
            'u_birthdate.required' => '생년월일: 필수 정보입니다.',
            'u_birthdate.regex' => '생년월일: 8자리 숫자로만 입력가능 합니다.',
            'u_tel.required' => '휴대폰 번호: 필수 정보입니다.',
            'u_tel.regex' => '휴대폰 번호: 휴대폰 번호가 정확하지 않습니다.',
            'u_postcode.required' => '우편번호: 필수 정보입니다.',
            'u_postcode.regex' => '우편번호: 5~6자리 숫자로만 입력가능 합니다.',
            'u_basic_address.required' => '기본주소: 필수 정보입니다.',
            'u_detail_address.required' => '상세주소: 필수 정보입니다.',
        ];
    }
}

