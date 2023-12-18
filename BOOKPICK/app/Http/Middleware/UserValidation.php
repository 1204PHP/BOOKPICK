<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        Log::debug( "### User 유효성 검사 시작 ###" );

        // User 정보 목록
        $userBaseKey = [
            'u_email'
            ,'u_password'
            ,'u_name'
            ,'u_birthdate'
            ,'u_tel'
            ,'u_postcode'
            ,'u_basic_address'
            ,'u_detail_address'
        ];

        // 유효성 검사 목록
        // 회원가입 : user.js 처리
        // 로그인, 회원정보 수정 : UserValiation.php 처리
        $userBaseValidation = [
            'u_email' => 'required|regex:/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/|unique:user,u_email|max:50',
            // 필수입력, RFC5322 표준 정규 표현식, 최대 50자 허용
            'u_password' => 'required|string|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$/|max:20',
            // 필수입력, 최소 8자 이상, 최대 30자, 최소 하나의 문자&하나의 숫자&하나의 특수문자(!@#$%^&*) 포함된 비밀번호 정규 표현식
            'u_name' => 'required|regex:/^[가-힣]{1,50}$/|max:50',
            // 필수입력, 한글이름만 허용, 특수문자&숫자&공백 불허, 최대 50자 허용
            'u_birthdate' => 'required|regex:/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/|max:11',
            // 필수입력, YYYY-MM-DD 허용
            'u_tel' => 'required|regex:/^010[0-9]{3,4}[0-9]{4}$/|max:11',
            // 필수입력, 대한민국 기준 휴대폰 번호 형식만 허용, 최대 11자 허용
            'u_postcode' => 'required|regex:/^\d{5}$/|max:6',
            // 필수입력, 대한민국 기준 우편번호 5~6자리, 최대 6자 허용
            'u_basic_address' => 'required|max:200',
            // 필수입력, 최대 200자 허용
            'u_detail_address' => 'max:50',
            // 필수입력, 최대 50자 허용
        ];

        // User Request Parameter
        $userRequestParam = [];
        foreach($userBaseKey as $val) {
            if($request->has($val)) {
                $userRequestParam[$val] = $request->$val;
            } else {
                unset($userBaseValidation[$val]);
            }
        }

        Log::debug(" ### User Request Parameter 획득 ### ", $userRequestParam);

        Log::debug(" ### 유효성 검사 목록 획득 ", $userBaseValidation);

        // 유효성 검사 진행
        $validator = Validator::make($userRequestParam, $userBaseValidation);

        // 유효성 검사 실패시 처리
        if($validator->fails()){
            Log::debug( "### User 유효성 검사 실패 ###" );
            $errorMsg = $this->errormsg();
            return redirect( '/' . $request->path())->withErrors($validator->errors()->first() );
        }

        Log::debug( "### User 유효성 검사 성공 ###" );
        return $next($request);
    }

    // 에러메세지 설정
    public function errormsg() {
        return [
            'u_email.required' => '이메일: 필수 정보입니다.',
            'u_email.regex' => '이메일: 올바른 이메일 형식이 아닙니다.',
            'u_email.unique' => '이메일: 이미 사용 중인 이메일입니다.',
            'u_password.required' => '비밀번호: 필수 정보입니다.',
            'u_password.regex' => '비밀번호: 보안강도 약함(8~20자 문자+숫자+특수문자 포함필요)',
            'u_name.required' => '이름: 필수 정보입니다.',
            'u_name.regex' => '이름: 한글로만 입력가능 합니다',
            'u_birthdate.required' => '생년월일: 필수 정보입니다.',
            'u_birthdate.regex' => '생년월일: 8자리 숫자로만 입력가능 합니다.',
            'u_tel.required' => '휴대폰 번호: 필수 정보입니다.',
            'u_tel.regex' => '휴대폰 번호: 휴대폰 번호가 정확하지 않습니다.',
            'u_postcode.required' => '우편번호: 필수 정보입니다.',
            'u_postcode.regex' => '우편번호: 5~6자리 숫자로만 입력가능 합니다.',
            'u_basic_address.required' => '기본주소: 필수 정보입니다.',
            'u_basic_address.required' => '기본주소: 한글, 숫자, 영어, - 만 입력가능 합니다.',
            'u_detail_address.required' => '상세주소: 한글, 숫자, 영어, - 만 입력가능 합니다.',
        ];
    }
}

