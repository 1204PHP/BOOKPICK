<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserValidation;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\LibraryCommentController;
use App\Http\Controllers\SocialLoginController;
use Laravel\Socialite\Facades\Socialite;

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
Route::get( '/', [TourController::class, 'index'])
->name( 'index' );

Route::get( '/home', [HomeController::class, 'index'])
->name( 'home' );

// Route::get( '/home', [HomeController::class, 'bestsellerGet'])
// ->name( 'bestsellerGet' );
// Route::get( '/home', [HomeController::class, 'newbookGet'])
// ->name( 'newbookGet' );

// 둘러보기 페이지
Route::get( '/index', function () {
    return view( 'book_tour' );
})->name( 'bookTour' );

Route::get( '/index', [TourController::class, 'index'])
->name( 'bookTour' );


// 나의 서재 페이지(유저컨트롤러 정의)

// 로그인 시 나의 서재 페이지로 이동
// 비로그인 시 로그인 페이지로 이동 
// 서재 도서 페이지
Route::get( '/library/finished', [LibraryController::class, 'libraryFinished'])
->name( 'getLibraryFinished' );
Route::get( '/library/reading', [LibraryController::class, 'libraryReading'])
->name( 'getLibraryReading' );
Route::get( '/library/wishlist', [LibraryController::class, 'librarywishlist'])
->name( 'getLibrarywishlist' );

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
Route::post( '/book/detail/wish', [BookController::class, 'bookDetailWishList'])
    ->name( 'postBookDetailWishList' );
Route::post( '/book/detail/library', [BookController::class, 'bookDetailUserLibrary'])
    ->name( 'postBookDetailUserLibrary' );

// 관리자 페이지
Route::get( '/admin', [AdminController::class, 'index']
)->name( 'getAdmin' );
Route::post( '/admin/bookInfo', [AdminController::class, 'adminbookInfo'])
->name( 'postAdminbookInfo' );
Route::post( '/admin/bookApi', [AdminController::class, 'adminbookApi'])
->name( 'postAdminbookApi' );
Route::post( '/admin/apiCate', [AdminController::class, 'adminApiCate'])
->name( 'postAdminApiCate' );
Route::post( '/admin/apiCateAuto', [AdminController::class, 'adminApiCateAuto'])
->name( 'postAdminApiCateAuto' );

// ### 유저관련(유효성 검사 포함) ###

// 로그인 화면 이동
Route::get( '/login', [UserController::class, 'getLogin'])
    ->name( 'getLogin' );

// 회원가입 화면 이동
Route::get( '/register', [UserController::class, 'getRegister'])
->name( 'getRegister' );

// 회원정보 수정 전 비밀번호 확인 화면 이동
Route::get( '/info/confirm', [UserController::class, 'getPasswordReconfirm'])
->name( 'getPasswordReconfirm' );

// 회원정보 수정 전 비밀번호 확인 처리
Route::post( '/info/confirm/process', [UserController::class, 'postPasswordReconfirm'])
->name( 'postPasswordReconfirm' );

// 회원정보 수정 화면 이동
Route::get( '/info', [UserController::class, 'getInfo'])
->name( 'getInfo' );

// 유효성 검사(미들웨어) 라우트 그룹 설정 : 로그인, 회원가입, 회원정보 수정
Route::middleware(['uservalidation'])->group(function () {
    // 로그인 처리
    Route::post('/login', [UserController::class, 'postLogin'])->name('postLogin');

    // 회원가입 처리
    Route::post('/register', [UserController::class, 'postRegister'])->name('postRegister');

    // 회원정보 수정 처리
    Route::put('/info', [UserController::class, 'putInfo'])->name('putInfo');
});

// 로그아웃 처리
Route::get('/logout', [UserController::class, 'getLogout'])
->name( 'getLogout' );

// 회원탈퇴 화면 이동
Route::get( '/withdrawal', [UserController::class, 'getWithdrawal'])
->name( 'getWithdrawal' );

// 회원탈퇴 처리
Route::delete( '/withdrawal', [UserController::class, 'deleteWithdrawal'])
->name( 'deleteWithdrawal' );

// ### 유저관련(소셜 로그인) ###

// 카카오
Route::get( '/auth/kakao', [SocialLoginController::class, 'loginKakao'])
->name( 'loginKakao' );
Route::get( '/auth/kakaocallback', [SocialLoginController::class, 'handleLoginKakaoCallback'])
->name( 'handleLoginKakaoCallback' );


// /auth/{} 세그먼트 파라미터로 설정해둘 시, 타 소셜 로그인을 할때에도 
// 컨트롤러, 라우트 하나로 설정할 수 있음
// /auth/{}
// /auth/{}/callback









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

