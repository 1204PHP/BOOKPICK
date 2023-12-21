<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserValidation;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryCommentController;

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
Route::get( '/', [HomeController::class, 'index'])
->name( 'index' );

Route::get( '/home', [HomeController::class, 'index'])
->name( 'home' );

// Route::get( '/home', [HomeController::class, 'bestsellerGet'])
// ->name( 'bestsellerGet' );
// Route::get( '/home', [HomeController::class, 'newbookGet'])
// ->name( 'newbookGet' );

// 나의 서재 페이지(유저컨트롤러 정의)
// 로그인 시 나의 서재 페이지로 이동
// 비로그인 시 로그인 페이지로 이동 
Route::get( '/library', [UserController::class, 'getLibrary'])
->name( 'getLibrary' );

// 둘러보기 페이지
Route::get( '/book/tour', function () {
    return view( 'book_tour' );
})->name( 'bookTour' );

// ### 세부 페이지 ###

// 서재 도서 상세 페이지
Route::get( '/library/detail/{id}', function ($id) {
    return view( 'user_library_detail', ['id' => $id] );
})->name( 'libraryDetail' );

// 검색 결과 페이지
Route::get('/search', [SearchController::class, 'index'])
    ->name('getsearch.index');

// 도서 상세 페이지
// Route::get( '/book/detail/{id}', function ($id) {
//     return view( 'book_detail', ['id' => $id] );
// })->name( 'bookDetail' );
Route::get( '/book/detail/{id}', [BookController::class, 'index'])
    ->name( 'getBookDetail' );
    Route::post( '/book/detail', [BookController::class, 'bookDetailWishList'])
    ->name( 'postBookDetailWishList' );
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
Route::put( '/info', [UserController::class, 'putInfo'])
->name( 'putInfo' );

// 로그아웃 처리
Route::get('/logout', [UserController::class, 'getLogout'])
->name( 'getLogout' );

// 회원탈퇴 화면 이동
Route::get( '/withdrawal', [UserController::class, 'getWithdrawal'])
->name( 'getWithdrawal' );

// 회원탈퇴 처리
Route::delete( '/withdrawal', [UserController::class, 'deleteWithdrawal'])
->name( 'deleteWithdrawal' );



// ### 책넣기위해 관리자 페이지 생성 ###
Route::get( '/admin', [AdminController::class, 'index']
)->name( 'getAdmin' );
Route::post( '/admin/bookInfo', [AdminController::class, 'adminBookInfo'])
->name( 'postAdminBookInfo' );
Route::post( '/admin/apiCate', [AdminController::class, 'adminApiCate'])
->name( 'postAdminApiCate' );
Route::post( '/admin/apiCateAuto', [AdminController::class, 'adminApiCateAuto'])
->name( 'postAdminApiCateAuto' );

// ### 나의 서재 도서 상세 > 독서기록
Route::middleware('auth')->prefix('library')->group(function () {
    Route::resource('detail', LibraryCommentController::class, [
        'names' => [
            'index' => 'lcDetailIndex', // (GET)나의 서재 도서 상세 화면 이동
            'create' => 'lcDetailCreate', // (GET)나의 서재 도서 상세 화면 이동(게시판 작성 화면 이동)
            'store' => 'lcDetailStore', // (POST)나의 서재 도서 상세 화면 게시글 insert 처리
            'show' => 'lcDetailShow', // (GET)나의 서재 도서 상세 화면 이동(게시판 디테일 화면 이동)
            'edit' => 'lcDetailEdit', // (GET)나의 서재 도서 상세 화면 이동(게시판 수정 화면 이동)
            'update' => 'lcDetailUpdate', // (PUT)나의 서재 도서 상세 화면 게시글 update 처리
            'destory' => 'lcDetailDestory', // (DELETE)나의 서재 도서 상세 화면 게시글 delete 처리
        ]
    ]);
});

