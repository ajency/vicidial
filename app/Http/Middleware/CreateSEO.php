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
                $params = $this->product($request->route()->parameters());
                $request->attributes->add(['params' => $params]);
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

    public function product(array $parameters) {
        $json = json_decode(singleproduct($parameters['product_slug'], $parameters['style_slug'], $parameters['color_slug']));
        $params =  (array) $json;
        $product_name = $params['title'];
        $selected_color_id = $params['selected_color_id'];
        foreach ($params['variant_group'] as $color_id => $color_set) {
            if($color_id == $selected_color_id) {
                $product_color = $color_set->name;
            }
            /*foreach ($color_set->images as $image_set) {
                if($image_set->is_primary) {$selected_image = $image_set->res->desktop->small_thumb;}
            }*/
        }
        $product_subtype = $params['category']->sub_type;

        SEOMeta::setTitle($product_name.' - '.$product_color.' - '.$product_subtype.' - Kidsuperstore.in');

        return $params;
    }
}
