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
    public function handle($request, Closure $next, $version)
    {
        switch ($version) {
            case 'v1':
                if ($request->user()->verified == true) {
                    return $next($request);
                } else {
                    abort(403, "Unverified User");
                }
                break;
            case 'v2':
                if ($request->all()['token_verified'] == true) {
                    return $next($request);
                } else {
                    abort(403, "Unverified User");
                }
                break;
        }
    }
}
