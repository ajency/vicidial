<?php

function setSEO($type=null, $parameters=null)
{
    switch ($type) {
        case 'home':
            homeseo();
            break;

        case 'product':
            productseo($parameters);
            break;

        default:
            defaultseo();
            break;
    }
}

function homeseo() {
	$domain = request()->root();
	$url = request()->url();
    SEOMeta::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
    SEOMeta::setDescription('Kidsuperstore.in: Online shopping site for kids wear and fashion in India. Buy Shoes, Clothing, Dresses and Accessories for Boys, Girls, Toddlers, Juniors and Infants. Shipping | Cash on Delivery | 30 days return.');
    SEOMeta::setCanonical($url);
    $keywords = ['online shopping for kids', 'online shopping', 'online shopping sites', 'online shopping india', 'india shopping', 'online shopping site', 'kss', 'india shopping online', 'buy online', 'kids wear', 'kids clothing', 'kids fashion', 'kids accessories', 'kidsuperstore', 'kidsuperstore.in', 'kid super store'];
    SEOMeta::setKeywords($keywords);

    OpenGraph::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
    OpenGraph::setDescription('Online shopping store in India for Shoes, Clothing, Dresses, Accessories for Kids. | Cash on Delivery | 30 days return.');
    OpenGraph::addImage($domain.'/img/logo-kss.png');
    OpenGraph::setUrl($url);

    OpenGraph::addImage($domain.'/img/kss_logo/kss_logo_180_110.jpg', ['width' => 180, 'height' => 110]);

    OpenGraph::addImage($domain.'/img/kss_logo/kss_logo_300_157.jpg', ['width' => 300, 'height' => 157]);

    OpenGraph::addImage($domain.'/img/kss_logo/kss_logo_1200_630.jpg', ['width' => 1200, 'height' => 630]);

    Twitter::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
    Twitter::setDescription('Online shopping store in India for Shoes, Clothing, Dresses, Accessories for Kids. | Cash on Delivery | 30 days return.');
    Twitter::addImage($domain.'/img/kss_logo/kss_logo_300_157.jpg');
    Twitter::setUrl($url);
}

function productseo($params) {
	$domain = request()->root();
	$url = request()->url();
	if($params == null) {
		defaultseo();
		return;
	}

    $product_name = $params['title'];
    $selected_color_id = $params['selected_color_id'];
    foreach ($params['variant_group'] as $color_id => $color_set) {
        if($color_id == $selected_color_id) {
            $product_color = $color_set->name;
        }
    }

    $selected_image = $domain."/img/placeholder.svg";

    if(count((array)$params['images'])>0) {
		$selected_image = $params['images'][0]->{'main'}->{'1x'};
	}

    if(isset($params['size'])) {
        $default_price = setDefaultPrice($params['variant_group']->{$selected_color_id}->variants, $params['size']);
    }
    else {
        $default_price = setDefaultPrice($params['variant_group']->{$selected_color_id}->variants);
    }

    $product_subtype = $params['category']->product_subtype;
    $product_gender = $params['category']->product_gender;
    $product_age_group = $params['category']->product_age_group;
    $product_department = $params['category']->product_category_type;

    SEOMeta::setTitle($product_name.' - '.$product_color.' - '.$product_subtype.' - Kidsuperstore.in', false);
    SEOMeta::setDescription('Buy '.$product_name.' - '.$product_color.' - only at ₹'.$default_price['sale_price'].' - '.$product_subtype.' for '.$product_gender.'  -  KidSuperStore.in');
    SEOMeta::setCanonical($url);
    $keywords = [$product_name, $product_subtype, $product_gender, $product_age_group, $product_department, $product_department.' for '.$product_gender, $product_subtype.' for '.$product_gender, 'Buy '.$product_name.' Online in India at best price only at KidSuperStore.in'];
    SEOMeta::setKeywords($keywords);

    OpenGraph::setTitle($product_name.' - '.$product_color.' - '.$product_subtype.' -  KidSuperStore.in', false);
    OpenGraph::setDescription('Buy '.$product_name.' - '.$product_color.' - only at ₹'.$default_price['sale_price'].' - '.$product_subtype.' for '.$product_gender.'  -  KidSuperStore.in');
    OpenGraph::addImage($selected_image);
    OpenGraph::setUrl($url);

    Twitter::setTitle($product_name.' - '.$product_color.' - '.$product_subtype.' -  KidSuperStore.in', false);
    Twitter::setDescription('Buy '.$product_name.' - '.$product_color.' - only at ₹'.$default_price['sale_price'].' - '.$product_subtype.' for '.$product_gender.'  -  KidSuperStore.in');
    Twitter::addImage($selected_image);
    Twitter::setUrl($url);
}

function defaultseo() {
	$domain = request()->root();
	$url = request()->url();
    SEOMeta::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
    SEOMeta::setDescription('Kidsuperstore.in: Online shopping site for kids wear and fashion in India. Buy Shoes, Clothing, Dresses and Accessories for Boys, Girls, Toddlers, Juniors and Infants. Shipping | Cash on Delivery | 30 days return.');
    SEOMeta::setCanonical($url);
    $keywords = ['online shopping for kids', 'online shopping', 'online shopping sites', 'online shopping india', 'india shopping', 'online shopping site', 'kss', 'india shopping online', 'buy online', 'kids wear', 'kids clothing', 'kids fashion', 'kids accessories', 'kidsuperstore', 'kidsuperstore.in', 'kid super store'];
    SEOMeta::setKeywords($keywords);

    OpenGraph::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
    OpenGraph::setDescription('Online shopping store in India for Shoes, Clothing, Dresses, Accessories for Kids. | Cash on Delivery | 30 days return.');
    OpenGraph::addImage($domain.'/img/logo-kss.png');
    OpenGraph::setUrl($url);

    OpenGraph::addImage($domain.'/img/kss_logo/kss_logo_180_110.jpg', ['width' => 180, 'height' => 110]);

    OpenGraph::addImage($domain.'/img/kss_logo/kss_logo_300_157.jpg', ['width' => 300, 'height' => 157]);

    OpenGraph::addImage($domain.'/img/kss_logo/kss_logo_1200_630.jpg', ['width' => 1200, 'height' => 630]);

    Twitter::setTitle('Online shopping for kids wear and fashion in India - KidSuperStore.in', false);
    Twitter::setDescription('Online shopping store in India for Shoes, Clothing, Dresses, Accessories for Kids. | Cash on Delivery | 30 days return.');
    Twitter::addImage($domain.'/img/kss_logo/kss_logo_300_157.jpg');
    Twitter::setUrl($url);
}