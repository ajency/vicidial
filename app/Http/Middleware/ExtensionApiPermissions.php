<?php

namespace App\Http\Middleware;

use Closure;

class ExtensionApiPermissions
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

        if (Auth::user()->hasPermission('api permissions')) {
            return $next($request);
        } else {
            abort(403);
        }

    }
