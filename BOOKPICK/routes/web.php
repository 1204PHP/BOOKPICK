<?php

use Illuminate\Support\Facades\Route;

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


// 세부 메뉴


// 유저관련 [ 로그인( 유효성체크 ), 회원가입( 유효성체크 ), 회원정보( 유효성체크 ) ]
Route::get( '/login', function () {
    return view( 'user_login' );
})->name( 'login' );

Route::post('/login-validate-ajax', 'UserValidationController@validateDataAjax')
->name( 'login-validate' );

Route::get( '/register', function () {
    return view( 'user_register' );
})->name( 'register' );

Route::post('/register-validate-ajax', 'UserValidationController@validateDataAjax')
->name( 'register-validate' );

Route::get('/info', function () {
    return view( 'user_info' );
})->name( 'info' );

Route::post('/info-validate-ajax', 'UserValidationController@validateDataAjax')
->name( 'info-validate' );

