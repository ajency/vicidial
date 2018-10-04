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
        SEOMeta::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in');
        SEOMeta::setDescription('Kidsuperstore.in: Online shopping site for kids wear and fashion in India. Buy Shoes, Clothing, Dresses and Accessories for Boys, Girls, Toddlers, Juniors and Infants. Shipping | Cash on Delivery | 30 days return.');

        OpenGraph::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in');
        OpenGraph::setDescription('Kidsuperstore.in: Online shopping site for kids wear and fashion in India. Buy Shoes, Clothing, Dresses and Accessories for Boys, Girls, Toddlers, Juniors and Infants. Shipping | Cash on Delivery | 30 days return.');

        Twitter::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in');
        Twitter::setDescription('Kidsuperstore.in: Online shopping site for kids wear and fashion in India. Buy Shoes, Clothing, Dresses and Accessories for Boys, Girls, Toddlers, Juniors and Infants. Shipping | Cash on Delivery | 30 days return.');
    }

    public function product() {
        SEOMeta::setTitle('Single Product|Kidsuperstore');
    }
}
