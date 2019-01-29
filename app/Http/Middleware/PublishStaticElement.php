<?php

namespace App\Http\Middleware;

use Closure;

class PublishStaticElement
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
        if ($request->user()->hasPermissionTo('publish static element')) {
            return $next($request);
        } else {
            abort(403);
        }

    }
}
