<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Book_info;
use App\Models\Book_detail_comment;
use App\Models\Book_detail_comment_state;
use App\Models\Book_detail_reply_state;
use App\Models\Book_detail_reply;
use App\Models\Book_api;
use App\Models\User_wishlist;
use App\Models\User_library;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    public function index($id)
    {
        try {
            Log::debug( "--------도서상세출력 시작---------" );
            $userId = Session::get('u_id');
            $result = Book_info::find($id);
            // wishFlg 설정
            if ($userId) {
                $wishList = User_wishlist::where('u_id', $userId)
                ->where('b_id', $id)->first();
                if($wishList) {
                    if($wishList->uw_flg === 1) {
                        // 로그인 된상태-> 찜안한상태
                        $wishFlg = 1;
                    } else if ($wishList->uw_flg === 0)
                        // 로그인 된상태-> 찜한상태
                        $wishFlg = 0;
                } else {
                    // 로그인 된 상태-> 찜을 한번도 누르지 않은 상태
                    $wishFlg = 1;
                }
            } else {
                // 로그인 안된상테
                $wishFlg = 2;
            }

            // 서재Flg 설정
            if ($userId) {
                $library = User_library::where('u_id', $userId)
                ->where('b_id', $id)->first();
                if($library) {
                    if($library->ul_flg === 1) {
                        // 로그인 된상태-> 나의서재에 삭제되어있는 상태
                        $libraryFlg = 1;
                    } else if ($library->ul_flg === 0)
                    // 로그인 된상태-> 나의서재에 등록되어있는 상태
                        $libraryFlg = 0;
                } else {
                    // 로그인 된상태-> 나의서재에 한번도 등록한적이없는상태
                    $libraryFlg = 1;
                }
            } else {
                // 로그인 안된상테
                $libraryFlg = 2;
            }


            // **********연관도서 부분***************
            $relatedCate = Book_info::where('b_id', $id)->first();
            $relatedBook = Book_info::select('b_id', 'b_img_url', 'b_title', 'b_author')
                        ->where('b_id', '<>', $id)
                        ->where(function ($query) use ($relatedCate) {
                            $query->Where('b_title', 'like', '%'.$relatedCate->b_title.'%')
                                ->orWhere('b_author', 'like', '%'.$relatedCate->b_author.'%');
                        })
                        ->limit(10)
                        ->get();
            if($relatedBook->count() < 10) {
                $additionResult = Book_info::select('b_id', 'b_img_url', 'b_title', 'b_author')
                                ->where('b_id', '<>', $id)
                                ->where('b_sub_cate', '=', $relatedCate->b_sub_cate) // 기존 결과와 중복되지 않도록
                                ->inRandomOrder()
                                ->limit(10 - $relatedBook->count()) // 부족한 만큼 추가로 가져오기
                                ->get();
                $relatedBook = $relatedBook->merge($additionResult);
                if($relatedBook->count() < 10) {
                    $additionResult1 = Book_api::select('*')
                    ->fromSub(
                                Book_api::where('book_apis.ac_id', 3)
                                ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
                                ->select('book_infos.b_id', 'book_infos.b_img_url', 'book_infos.b_title', 'book_infos.b_author','book_apis.deleted_at')
                                ->orderByDesc('book_apis.created_at')
                                ->where('book_apis.ba_rank', '>=', 11)
                                ->where('book_apis.ba_rank', '<=', 30)
                                ->limit(20),
                                'book_apis'
                            )
                    ->inRandomOrder()
                    ->limit(10 - $relatedBook->count())
                    ->get();
                    $relatedBook = $relatedBook->concat($additionResult1);
                }
            }

            // *************댓글부분******************
            $commentResult = Book_detail_comment::join('users', 'book_detail_comments.u_id', '=', 'users.u_id')
                            ->select('book_detail_comments.*','users.u_name')
                            ->where('book_detail_comments.b_id', $id)
                            ->addSelect(['like' => Book_detail_comment_state::selectRaw('COUNT(*)')
                                ->whereColumn('book_detail_comment_states.bdc_id', 'book_detail_comments.bdc_id')
                                ->where('book_detail_comment_states.bdcs_flg', 1)
                            ])
                            ->addSelect(['dislike' => Book_detail_comment_state::selectRaw('COUNT(*)')
                                ->whereColumn('book_detail_comment_states.bdc_id', 'book_detail_comments.bdc_id')
                                ->where('book_detail_comment_states.bdcs_flg', 2)
                            ])
                            ->addSelect(['reply_count' => Book_detail_reply::selectRaw('COUNT(*)')
                                ->whereColumn('book_detail_replies.bdc_id', 'book_detail_comments.bdc_id')
                            ])
                            ->orderby('book_detail_comments.created_at', 'desc')
                            ->limit(5)
                            ->get();
            Log::debug($id);
            Log::debug($commentResult);
            Log::debug( "--------도서상세출력 끝-----------" );
            return view('book_detail',
                        ['result' => $result,
                        'wishFlg' => $wishFlg,
                        'libraryFlg' => $libraryFlg,
                        'commentResult' => $commentResult,
                        'relatedBook' => $relatedBook]);
        } catch(Exception $e) {
            Log::error( "--------도서상세출력 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function bookDetailWishList( Request $request )
    {
        try {
            Log::debug( "--------찜등록관리 시작---------" );
            
            $userId = Session::get('u_id');
            $bookId = $request->input('b_id');
            Log::debug( "userId : ".$userId );
            Log::debug( "bookId : ".$bookId );
            if ($userId) { // 세션에 사용자 ID가 존재하는 경우
                $record = User_wishlist::where('u_id', $userId)
                            ->where('b_id', $bookId)
                            ->first();
                if($record) {
                    if($record->uw_flg===0) {
                        User_wishlist::where('u_id', $userId)
                            ->where('b_id', $bookId)
                            ->update([
                                'uw_flg'=> 1,
                        ]);
                        Log::debug( "user_wishlist uw_flg=1로 수정(찜 삭제)" );
                    } else if( $record->uw_flg===1 ) {
                        User_wishlist::where('u_id', $userId)
                            ->where('b_id', $bookId)
                            ->update([
                                'uw_flg'=> 0,
                        ]);
                        Log::debug( "user_wishlist uw_flg=1로 수정(찜 다시 등록)" );
                    }
                } else {
                    User_wishlist::create([
                        'u_id' => $userId,
                        'b_id' => $bookId,
                    ]);
                    Log::debug( "user_wishlist uw_flg=0로 생성(찜 등록)" );
                }
            } else { // 세션에 사용자 ID가 없는 경우
                Log::debug("세션에 사용자 ID가 없음");
                return redirect()->route('getLogin');
            }
            Log::debug( "--------찜관리 끝---------" );
            return redirect()->route('getBookDetail',['id' => $bookId]);
        } catch(Exception $e) {
            Log::error( "--------찜등록관리 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function bookDetailUserLibrary( Request $request )
    {
        try {
            Log::debug( "--------서재등록관리 시작---------" );
            $userId = Session::get('u_id');
            $bookId = $request->input('library_b_id');
            $startDate = ($request->input('detailStartDate') === NULL ? now()->format('Y-m-d') : $request->input('detailStartDate'));
            $endDate = ($request->input('detailEndDate') === NULL ? now()->format('Y-m-d') : $request->input('detailEndDate'));
            Log::debug( "userId : ".$userId );
            Log::debug( "bookId : ".$bookId );
            Log::debug( "startDate : ".$startDate );
            Log::debug( "endDate : ".$endDate );
            if ($userId) { // 세션에 사용자 ID가 존재하는 경우
                $record = User_library::where('u_id', $userId)
                            ->where('b_id', $bookId)
                            ->first();
                if($record) { // 해당 책 정보가 있을경우
                    if($record->ul_flg===0) { // 데이터가 이미 있는 경우(플래그로 삭제처리)
                        User_library::where('u_id', $userId)
                            ->where('b_id', $bookId)
                            ->update([
                                // 'ul_start_at' => now()->format('Y-m-d'),
                                // 'ul_end_at' => now()->format('Y-m-d'),
                                'ul_flg'=> 1,
                        ]);
                        Log::debug( "User_library uw_flg=1로 수정(서재 삭제)" );
                    } else if( $record->ul_flg===1 ) { // 데이터가 삭제 되어 있는 경우(다시 추가 처리)
                        User_library::where('u_id', $userId)
                            ->where('b_id', $bookId)
                            ->update([
                                'ul_start_at' => $startDate,
                                'ul_end_at' => $endDate,
                                'ul_flg'=> 0,
                        ]);
                        Log::debug( "User_library uw_flg=0로 수정(서재 다시 등록)" );
                    }
                } else { //해당 책 정보가 없을경우
                    User_library::create([
                        'u_id' => $userId,
                        'b_id' => $bookId,
                        'ul_start_at' => $startDate,
                        'ul_end_at' => $endDate,
                    ]);
                    Log::debug( "User_library uw_flg=0로 생성(서재 등록)" );
                }
                Log::debug( "--------서재등록관리 끝---------" );
                return redirect()->route('getBookDetail',['id' => $bookId]);
            } else { // 세션에 사용자 ID가 없는 경우
                Log::debug("세션에 사용자 ID가 없음");
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "---------서재등록관리 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function bookDetailCommentInsert($id, Request $request)
    {
        try {
            Log::debug( "--------도서 상세 댓글 삽입 시작---------" );
            $userId = Session::get('u_id');
            $comment = $request->content;
            if($comment === NULL) {
                $comment = "";
            }

            if ($userId) {
                $result = Book_detail_comment::create([
                    'bdc_comment' => $comment,
                    'b_id' => $id,
                    'u_id' => $userId,
                ]);
                Log::debug( "userId : ". $userId );
                Log::debug( "comment : ". $comment );
                return redirect()->route('getBookDetail', ['id' => $id]);
            } else {
                Log::debug( "--------사용자 ID가 없음---------" );
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재 도서 댓글 삽입  에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function bookDetailCommentPrint(Request $request)
    {
        try {
            Log::debug( "--------댓글 출력 ajax 시작---------" );
            $id= $request->b_id;
            $commentResult = Book_detail_comment::join('users', 'book_detail_comments.u_id', '=', 'users.u_id')
            ->select('book_detail_comments.*','users.u_name')
            ->where('book_detail_comments.b_id', $id)
            ->addSelect(['like' => Book_detail_comment_state::selectRaw('COUNT(*)')
                ->whereColumn('book_detail_comment_states.bdc_id', 'book_detail_comments.bdc_id')
                ->where('book_detail_comment_states.bdcs_flg', 1)
            ])
            ->addSelect(['dislike' => Book_detail_comment_state::selectRaw('COUNT(*)')
                ->whereColumn('book_detail_comment_states.bdc_id', 'book_detail_comments.bdc_id')
                ->where('book_detail_comment_states.bdcs_flg', 2)
            ])
            ->addSelect(['reply_count' => Book_detail_reply::selectRaw('COUNT(*)')
                ->whereColumn('book_detail_replies.bdc_id', 'book_detail_comments.bdc_id')
            ])
            ->orderby('book_detail_comments.created_at', 'desc')
            ->limit(5)
            ->get();
            
            $commentCount = Book_detail_comment::where('b_id', $id)
                ->count();

            $responseData = [
                'commentResult' => $commentResult,
                'commentCount' => $commentCount,
            ];
            Log::debug( "--------댓글 출력 ajax 끝---------" );
            return response()->json($responseData);
        } catch(Exception $e) {
            Log::error( "--------댓글 출력 ajax  에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function bookDetailReplyPrint(Request $request)
    {
        try {
            Log::debug( "--------대댓글 출력 ajax 시작---------" );
            $bdcId= $request->bdc_id;
            $replyResult = Book_detail_reply::join('users', 'Book_detail_replies.u_id', '=', 'users.u_id')
            ->select('Book_detail_replies.*','users.u_name')
            ->where('Book_detail_replies.bdc_id', $bdcId)
            ->addSelect(['like' => Book_detail_reply_state::selectRaw('COUNT(*)')
                ->whereColumn('book_detail_reply_states.bdr_id', 'Book_detail_replies.bdr_id')
                ->where('book_detail_reply_states.bdrs_flg', 1)
            ])
            ->addSelect(['dislike' => Book_detail_reply_state::selectRaw('COUNT(*)')
                ->whereColumn('book_detail_reply_states.bdr_id', 'Book_detail_replies.bdr_id')
                ->where('book_detail_reply_states.bdrs_flg', 2)
            ])
            ->orderby('Book_detail_replies.created_at', 'asc')
            ->get();
            $responseData = [
                'replyResult' => $replyResult,
            ];
            Log::debug( "--------대댓글 출력 ajax 끝---------" );
            return response()->json($responseData);
        } catch(Exception $e) {
            Log::error( "--------대댓글 출력 ajax  에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }
}



