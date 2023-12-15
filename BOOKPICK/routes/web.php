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


// 세부 메뉴

// 유저관련 [ 로그인( 유효성체크 ), 회원가입( 유효성체크 ), 회원정보( 유효성체크 ) ]
// Route::middleware([UserValidation::class])->group(function () {
//     Route::get( '/login', [UserController::class, 'getLogin'])
//     ->name( 'getLogin' );

//     Route::post(' /login ', [UserController::class, 'postLogin'])
//     ->name( 'postLogin' );

//     Route::get( '/register', [UserController::class, 'getRegister'])
//     ->name( 'getRegister' );

//     Route::post(' /register ', [UserController::class, 'postRegister'])
//     ->name( 'postRegister' );

//     Route::get( '/info', [UserController::class, 'getInfo'])
//     ->name( 'getInfo' );

//     Route::put( '/info/{id}', [UserController::class, 'putInfo'])
//     ->name( 'putInfo' );

//     Route::get('/logout', [UserController::class, 'getLogout'])
//     ->name( 'getLogout' );
// });

Route::get( '/login', [UserController::class, 'getLogin'])
    ->name( 'getLogin' );

Route::post(' /login ', [UserController::class, 'postLogin'])
->name( 'postLogin' );

Route::get( '/register', [UserController::class, 'getRegister'])
->name( 'getRegister' );

Route::post(' /register ', [UserController::class, 'postRegister'])
->name( 'postRegister' );

Route::get( '/info', [UserController::class, 'getInfo'])
->name( 'getInfo' );

Route::put( '/info/{id}', [UserController::class, 'putInfo'])
->name( 'putInfo' );

Route::get('/logout', [UserController::class, 'getLogout'])
->name( 'getLogout' );



