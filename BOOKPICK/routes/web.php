<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserValidation;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ### 헤더 ###

// 메인 페이지
Route::get( '/', function () {
    return view( 'home' );
})->name( 'index' );
Route::get( '/home', function () {
    return view( 'home' );
})->name( 'home' );

// 나의 서재 페이지
Route::get( '/library', function () {
    return view( 'user_library' );
})->name( 'library' );

// 둘러보기 페이지
Route::get( '/book/tour', function () {
    return view( 'book_tour' );
})->name( 'bookTour' );

// ### 세부 페이지 ###

// 서재 도서 상세 페이지
Route::get( '/library/detail', function () {
    return view( 'user_library_detail' );
})->name( 'libraryDetail' );

// 검색 결과 페이지
Route::get('/search', [SearchController::class, 'index'])
    ->name('search.index');

// 도서 상세 페이지
Route::get( '/book/detail', function () {
    return view( 'book_detail' );
})->name( 'bookDetail' );

// ### 유저관련(유효성 검사 포함) ###

// 로그인 화면 이동
Route::get( '/login', [UserController::class, 'getLogin'])
    ->name( 'getLogin' );

// 로그인 처리
Route::middleware( 'uservalidation' )
    ->post('/login', [UserController::class, 'postLogin'])
    ->name('postLogin'); 

// 회원가입 화면 이동
Route::get( '/register', [UserController::class, 'getRegister'])
->name( 'getRegister' );

// 회원가입 처리
Route::middleware( 'uservalidation' )
    ->post('/register', [UserController::class, 'postRegister'])
    ->name('postRegister');

// 회원정보 수정 화면 이동
Route::get( '/info', [UserController::class, 'getInfo'])
->name( 'getInfo' );

// 회원정보 수정 처리
Route::put( '/info/{id}', [UserController::class, 'putInfo'])
->name( 'putInfo' );

// 로그아웃 처리
Route::get('/logout', [UserController::class, 'getLogout'])
->name( 'getLogout' );

// 회원탈퇴 화면 이동
Route::get( '/withdrawal', [UserController::class, 'getWithdrawal'])
->name( 'getWithdrawal' );

// 회원탈퇴 처리
Route::post('/withdrawl', [UserController::class, 'postWithdrawal'])
->name( 'postWithdrawal' );


