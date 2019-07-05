<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $all_headers = getallheaders();
        if (isset($all_headers['X-Chrome-Extension']) && $all_headers['X-Chrome-Extension'] == 'KSS') {
            return $next($request)
                ->header("Access-Control-Allow-Origin", "*")
                ->header("Access-Control-Allow-Methods", "POST, GET, OPTIONS, PUT, DELETE")
                ->header("Access-Control-Allow-Headers", "Content-Type, Access-Control-Allow-Origin, Authorization");
        }
        
        return $next($request)
            ->header("Access-Control-Allow-Origin", config('app.angular_url'))
            ->header("Access-Control-Allow-Methods", "POST, GET, OPTIONS, PUT, DELETE")
            ->header("Access-Control-Allow-Headers", "Content-Type, Access-Control-Allow-Origin, Authorization")
            ->header("Access-Control-Allow-Credentials", 'true');
    }
}
