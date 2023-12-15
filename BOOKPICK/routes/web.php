<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserValidation;
use App\Http\Controllers\UserController;

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

// 메인 메뉴
Route::get( '/', function () {
    return view( 'home' );
})->name( 'index' );

Route::get( '/home', function () {
    return view( 'home' );
})->name( 'home' );

Route::get( '/cate', function () {
    return view( 'cate' );
})->name( 'cate' );

Route::get( '/bestseller', function () {
    return view( 'bestseller' );
})->name( 'bestseller' );

Route::get( '/recommend', function () {
    return view( 'recommend' );
})->name( 'recommend' );


// 유저관련 [ 로그인( 유효성 검사 ), 회원가입( 유효성체크 ), 회원정보 수정 ]

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



