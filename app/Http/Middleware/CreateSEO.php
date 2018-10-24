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
                $this->home($request->root(), $request->url());
                break;

            case 'product':
                $params = $this->product($request->root(), $request->url(), $request->route()->parameters());
                $request->attributes->add(['params' => $params]);
                break;

            default:
                $params = $this->defaultseo($request->root(), $request->url());
                $request->attributes->add(['params' => $params]);
                break;
        }
        return $next($request);
    }

    public function home(string $domain, string $url) {
        SEOMeta::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
        SEOMeta::setDescription('Kidsuperstore.in: Online shopping site for kids wear and fashion in India. Buy Shoes, Clothing, Dresses and Accessories for Boys, Girls, Toddlers, Juniors and Infants. Shipping | Cash on Delivery | 30 days return.');
        //SEOMeta::setCanonical($url);
        $keywords = ['online shopping for kids', 'online shopping', 'online shopping sites', 'online shopping india', 'india shopping', 'online shopping site', 'kss', 'india shopping online', 'buy online', 'kids wear', 'kids clothing', 'kids fashion', 'kids accessories', 'kidsuperstore', 'kidsuperstore.in', 'kid super store'];
        SEOMeta::setKeywords($keywords);

        OpenGraph::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
        OpenGraph::setDescription('Online shopping store in India for Shoes, Clothing, Dresses, Accessories for Kids. | Cash on Delivery | 30 days return.');
        //OpenGraph::addImage($domain.'/img/logo-kss.png');
        //OpenGraph::setUrl($url);

        Twitter::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
        Twitter::setDescription('Online shopping store in India for Shoes, Clothing, Dresses, Accessories for Kids. | Cash on Delivery | 30 days return.');
        //Twitter::addImage($domain.'/img/logo-kss.png');
        //Twitter::setUrl($url);
    }

    public function product(string $domain, string $url, array $parameters) {
        $json = json_decode(singleproduct($parameters['product_slug']));
        $params =  (array) $json;
        $product_name = $params['title'];
        $selected_color_id = $params['selected_color_id'];
        foreach ($params['variant_group'] as $color_id => $color_set) {
            if($color_id == $selected_color_id) {
                $product_color = $color_set->name;
                foreach ($color_set->images as $image_set) {
                    if($image_set->is_primary) {$selected_image = $image_set->res->desktop->small_thumb;}
                }
                foreach ($color_set->variants as $size_set) {
                    if($size_set->is_default) {
                        $sale_price = $size_set->sale_price;
                    }
                }
            }
        }

        $product_subtype = $params['category']->sub_type;
        $product_gender = $params['category']->gender;
        $product_age_group = $params['category']->age_group;
        $product_department = $params['category']->type;

        SEOMeta::setTitle($product_name.' - '.$product_color.' - '.$product_subtype.' - Kidsuperstore.in', false);
        SEOMeta::setDescription('Buy '.$product_name.' - '.$product_color.' - only at ₹'.$sale_price.' - '.$product_subtype.' for '.$product_gender.'  -  KidSuperStore.in');
        //SEOMeta::setCanonical($url);
        $keywords = [$product_name, $product_subtype, $product_gender, $product_age_group, $product_department, $product_department.' for '.$product_gender, $product_subtype.' for '.$product_gender, 'Buy '.$product_name.' Online in India at best price only at KidSuperStore.in'];
        SEOMeta::setKeywords($keywords);

        OpenGraph::setTitle($product_name.' - '.$product_color.' - '.$product_subtype.' -  KidSuperStore.in', false);
        OpenGraph::setDescription('Buy '.$product_name.' - '.$product_color.' - only at ₹'.$sale_price.' - '.$product_subtype.' for '.$product_gender.'  -  KidSuperStore.in');
        //OpenGraph::addImage($domain.$selected_image);
        //OpenGraph::setUrl($url);

        Twitter::setTitle($product_name.' - '.$product_color.' - '.$product_subtype.' -  KidSuperStore.in', false);
        Twitter::setDescription('Buy '.$product_name.' - '.$product_color.' - only at ₹'.$sale_price.' - '.$product_subtype.' for '.$product_gender.'  -  KidSuperStore.in');
        //Twitter::addImage($domain.$selected_image);
        //Twitter::setUrl($url);

        return $params;
    }

    public function defaultseo(string $domain, string $url) {
        SEOMeta::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
        SEOMeta::setDescription('Kidsuperstore.in: Online shopping site for kids wear and fashion in India. Buy Shoes, Clothing, Dresses and Accessories for Boys, Girls, Toddlers, Juniors and Infants. Shipping | Cash on Delivery | 30 days return.');
        //SEOMeta::setCanonical($url);
        $keywords = ['online shopping for kids', 'online shopping', 'online shopping sites', 'online shopping india', 'india shopping', 'online shopping site', 'kss', 'india shopping online', 'buy online', 'kids wear', 'kids clothing', 'kids fashion', 'kids accessories', 'kidsuperstore', 'kidsuperstore.in', 'kid super store'];
        SEOMeta::setKeywords($keywords);

        OpenGraph::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
        OpenGraph::setDescription('Online shopping store in India for Shoes, Clothing, Dresses, Accessories for Kids. | Cash on Delivery | 30 days return.');
        //OpenGraph::addImage($domain.'/img/logo-kss.png');
        //OpenGraph::setUrl($url);

        Twitter::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
        Twitter::setDescription('Online shopping store in India for Shoes, Clothing, Dresses, Accessories for Kids. | Cash on Delivery | 30 days return.');
        //Twitter::addImage($domain.'/img/logo-kss.png');
        //Twitter::setUrl($url);
    }
}
