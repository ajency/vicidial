<?php

namespace App\Http\Middleware;

use Closure;

use SEOMeta;
use OpenGraph;
use Twitter;

class CreateSEO
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        switch ($type) {
            case 'home':
                $this->home();
                break;

            case 'product':
                $this->product();
                break;
            
            default:
                # code...
                break;
        }
        return $next($request);
    }

    public function home() {
        SEOMeta::setTitle('Home|Kidsuperstore');
    }

    public function product() {
        SEOMeta::setTitle('Single Product|Kidsuperstore');
    }
}
