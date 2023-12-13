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
})->name( 'home' );

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


// 유저관련 ( 로그인, 회원가입, 회원정보 )
Route::get( '/user/login', function () {
    return view( 'user_login' );
})->name( 'user_login' );

Route::get( '/user/register', function () {
    return view( 'user_register' );
})->name( 'user_register' );

Route::get('/user/info', function () {
    return view( 'user_info' );
})->name( 'user_info' );

