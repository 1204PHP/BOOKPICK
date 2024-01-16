<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        '/book/detail/comment/print',
        '/book/detail/reply/print',
        '/book/detail/comment/insert',
        '/book/detail/reply/insert',
        '/book/detail/comment/like',
        '/book/detail/comment/dislike',
        '/book/detail/reply/like',
        '/book/detail/reply/dislike',
    ];
}
