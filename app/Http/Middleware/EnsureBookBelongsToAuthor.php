<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureBookBelongsToAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($request->book, $request->author) && $request->book->author_id != $request->author->id) {

            $response = [
                'success' => false,
                'data' => [],
                'message' => 'The author doesnt own this book!',
                'code' => 500,
            ];

            return response()->json($response, 403);
        }

        return $next($request);
    }
}
