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

Route::get( '/', function () {
    return view( 'main' );
})->name( 'main_home' );

Route::get( '/test', function () {
    return view( 'main2' );
})->name( 'main_home2' );

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

