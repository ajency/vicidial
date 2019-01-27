<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->verified == true) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
