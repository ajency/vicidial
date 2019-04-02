<?php

namespace App;

use Ajency\Connections\ElasticQuery;
use App\ProductColor;
use App\SizechartImage;

class SingleProduct
{
    protected $productData, $variantData, $productColor;

    protected static $facets;

    const PRODUCT_ATTRIBUTES = [
        "product_title",
        "product_id",
        "product_slug",
        "product_name",
        "product_style",
        "product_description",
        "product_att_sleeves",
        "product_att_fashionability",
        "product_att_material",
        "product_att_occasion",
        "product_att_wash",
        "product_att_fabric_type",
        "product_att_product_type",
        "product_att_other_attribute",
        "product_vendor",
        "product_is_dropshipping",
        "product_rank",
    ];

    const PRODUCT_FACETS = [
        "product_age_group",
        "product_brand",
        "product_category_type",
        "product_color_html",
        "product_gender",
        "product_metatag",
        "product_subtype",
    ];

    const VARIANT_ATTRIBUTES = [
        "variant_id",
        "variant_list_price",
        "variant_sale_price",
        "variant_discount",
        "variant_discount_percent",
        "variant_barcode",
    ];

    const VARIANT_FACETS = [
        "variant_size",
    ];

    public function __construct($slug)
    {
        if (is_null(self::$facets)) {
            self::$facets = Facet::select(['facet_name', 'facet_value', 'display_name', 'slug', 'sequence'])->get();
        }
        $this->setSlugElasticData($slug);
        $this->getProductColor();
    }

    private function getProductColor()
    {
        $this->productColor = ProductColor::where('product_id', $this->productData['product_id'])->where('color_id', $this->productData['product_color_id'])->first();
    }

    private function setSlugElasticData($product_slug)
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));

        $facetName  = $q::createTerm('search_data.string_facet.facet_name', "product_slug");
        $facetValue = $q::createTerm('search_data.string_facet.facet_value', $product_slug);
        $filter     = $q::addFilterToQuery([$facetName, $facetValue]);
        $nested1    = $q::createNested('search_data.string_facet', $filter);
        $nested2    = $q::createNested('search_data', $nested1);
        $q->setQuery($nested2)
            ->setSource(['search_result_data', 'variants']);

        $products = collect($q->search()["hits"]["hits"]);
        if ($products->isEmpty()) {
            throw new \Exception("Product with slug " . $product_slug . " not found", 1);
        }

        $this->productData = collect($products->first()['_source']['search_result_data']);
        $this->variantData = collect($products->first()['_source']['variants']);

    }

    public function getElasticData()
    {
        return [$this->productData, $this->variantData];
    }

    private function getProductAttributes()
    {
        $attributes = [];
        foreach (self::PRODUCT_ATTRIBUTES as $attribute_name) {
            $attributes[$attribute_name] = (isset($this->productData[$attribute_name])) ? $this->productData[$attribute_name] : "";
        }
        return $attributes;
    }

    private function getProductFacets()
    {
        $facets = [];
        foreach (self::PRODUCT_FACETS as $facetName) {
            switch ($facetName) {
                case 'product_metatag':
                    $facets[$facetName] = [];
                    if (isset($this->productData['product_metatag']) && is_array($this->productData['product_metatag'])) {
                        foreach ($this->productData['product_metatag'] as $metatag) {
                            $facetData            = self::$facets->where('facet_name', $facetName)->where('facet_value', $metatag)->first();
                            $facets[$facetName][] = [
                                'id'   => $id,
                                'name' => $facetData['display_name'],
                                'slug' => $facetData['slug'],
                            ];
                        }
                    }
                    break;
                case 'product_color_html':
                    $id = (isset($this->productData['product_color_id'])) ? $this->productData["product_color_id"] : null;
                    break;

                default:
                    $id = null;
                    break;
            }
            if (in_array($facetName, ['product_metatag'])) {
                continue;
            }

            $facetData          = self::$facets->where('facet_name', $facetName)->where('facet_value', $this->productData[$facetName])->first();
            $facets[$facetName] = [
                'id'   => $id,
                'name' => $facetData['display_name'],
                'slug' => $facetData['slug'],
            ];
        }
        return $facets;
    }

    private function getVariantAttributes($variant)
    {
        $attributes = [];
        foreach (self::VARIANT_ATTRIBUTES as $attribute_name) {
            $attributes[$attribute_name] = (isset($variant[$attribute_name])) ? $variant[$attribute_name] : "";
        }
        return $attributes;
    }

    private function getVariantFacets($variant)
    {
        $facets = [];
        foreach (self::VARIANT_FACETS as $facetName) {
            switch ($facetName) {
                case 'variant_size':
                    $facetData          = self::$facets->where('facet_name', 'variant_size_name')->where('facet_value', $variant['variant_size_name'])->first();
                    $facets[$facetName] = [
                        'id'       => $variant['variant_size_id'],
                        'name'     => $facetData['display_name'],
                        'slug'     => $facetData['slug'],
                        'sequence' => $facetData['sequence'],
                    ];
                    break;
            }
        }
        return $facets;
    }

    private function getVariants()
    {
        $variants  = [];
        $defaultId = defaultVariant($this->variantData);
        foreach ($this->variantData as $variant) {
            $variantInfo                       = [];
            $variantInfo['variant_attributes'] = $this->getVariantAttributes($variant);
            $variantInfo['variant_facets']     = $this->getVariantFacets($variant);
            $variantInfo['is_default']         = $defaultId == $variant['variant_id'];
            $variants[]                        = $variantInfo;
        }
        return $variants;
    }

    private function getImages()
    {
        $images = $this->productColor->getAllImages(['main', 'thumb', 'zoom']);
        $seq    = 1;
        foreach ($images as $key => $image) {
            $images[$key]['sequence'] = $seq++;
        }
        return $images;
    }

    private function isSellable()
    {
        return $this->productData['product_att_ecom_sales'];
    }

    private function getColorVariantElasticData()
    {
        $q = new ElasticQuery;
        $q->setIndex(config("elastic.indexes.product"));
        $productID  = $this->productData['product_id'];
        $facetName  = $q::createTerm('search_data.number_facet.facet_name', "product_id");
        $facetValue = $q::createTerm('search_data.number_facet.facet_value', $productID);
        $must       = $q::addToBoolQuery('must', [$facetName, $facetValue]);
        $nested     = $q::createNested('search_data.number_facet', $must);
        $q->setQuery($nested)->setSource(['search_result_data']);
        return $q->search()['hits']['hits'];
    }

    private function getColorVariants()
    {
        $colorVariants     = [];
        $productID         = $this->productData['product_id'];
        $colorId           = $this->productData['product_color_id'];
        $colorVariantsData = $this->getColorVariantElasticData();
        foreach ($colorVariantsData as $cved) {
            $cvd                         = $cved['_source']['search_result_data'];
            $colorVariant                = [];
            $facetData                   = self::$facets->where('facet_name', 'product_color_html')->where('facet_value', $cvd['product_color_html'])->first();
            $colorVariant['color_id']    = $cvd['product_color_id'];
            $colorVariant['color_name']  = $facetData['display_name'];
            $colorVariant['image']       = getProductDefaultImage($productID, $cvd['product_color_id'], "variant-thumb");
            $colorVariant['url']         = url('/' . $cvd['product_slug'] . '/buy');
            $colorVariant['is_selected'] = $cvd['product_color_id'] == $colorId;
            $colorVariant['hexcode']     = $facetData['slug'];
            $colorVariants[]             = $colorVariant;
        }
        return $colorVariants;
    }

    private function getBreadcrumbs()
    {
        $order       = config('product.breadcrumb_order');
        $position    = 1;
        $breadcrumbs = [];
        $crumb       = collect();
        foreach ($order as $breadcrumbKey) {
            $facetData = self::$facets->where('facet_name', $breadcrumbKey)->where('facet_value', $this->productData[$breadcrumbKey])->first();
            $crumb->push($facetData['slug']);
            $breadcrumbs[] = [
                'title'    => $facetData['display_name'],
                'url'      => url(createUrl('list', $crumb->toArray())),
                'position' => $position++,
            ];
        }
        return $breadcrumbs;
    }

    private function getSimilarProductsElasticData()
    {
        $productID                        = $this->productData['product_id'];
        $defaultFilters                   = setDefaultFilters(['search_object' => []]);
        $defaultFilters['primary_filter'] = [
            'product_category_type' => $this->productData['product_category_type'],
            'product_gender'        => $this->productData['product_gender'],
            'product_age_group'     => $this->productData['product_age_group'],
            'product_subtype'       => $this->productData['product_subtype'],
        ];
        $q = new ElasticQuery;
        $q->setIndex(config('elastic.indexes.product'));
        $mustFilter    = setElasticFacetFilters($q, ['search_object' => $defaultFilters], false)[0];
        $mustNotFilter = setElasticFacetFilters($q, ['search_object' => ['boolean_filter' => ['product_id' => $productID]]], false)[0];
        $filters       = $q::addToBoolQuery('must', $mustFilter);
        $filters       = $q::addToBoolQuery('must_not', $mustNotFilter, $filters);
        $query         = $q::createNested("search_data", $filters);
        $q->setQuery($query)->setSize(4)->setSource(['search_result_data', 'variants']);
        return $q->search()['hits']['hits'];
    }

    private function getSimilarProducts()
    {
        $similarProducts     = [];
        $productID           = $this->productData['product_id'];
        $similarProductsData = $this->getSimilarProductsElasticData();
        foreach ($similarProductsData as $sped) {
            $spd                          = $sped['_source']['search_result_data'];
            $spdVariants                  = $sped['_source']['variants'];
            $similarProduct               = [];
            $similarProduct['url']        = url('/' . $spd['product_slug'] . '/buy');
            $similarProduct['title']      = $spd['product_title'];
            $similarProduct['image']      = getProductDefaultImage($spd['product_id'], $spd['product_color_id'], 'list-view');
            $variant                      = defaultVariant($spdVariants, false);
            $similarProduct['sale_price'] = $variant['variant_sale_price'];
            $similarProduct['list_price'] = $variant['variant_list_price'];
            $similarProducts[]            = $similarProduct;
        }
        return $similarProducts;
    }

    private function getSeoAttributes()
    {
        $productName    = $this->productData['product_title'];
        $productColor   = self::$facets->where('facet_name', 'product_color_html')->where('facet_value', $this->productData['product_color_html'])->first()['display_name'];
        $productSubtype = self::$facets->where('facet_name', 'product_subtype')->where('facet_value', $this->productData['product_subtype'])->first()['display_name'];

        $title       = $productName . ' - ' . $productColor . ' - ' . $productSubtype . ' - Kidsuperstore.in';
        $url         = url('/' . $this->productData['product_slug'] . '/buy');
        $description = 'Buy ' . $productName . ' - ' . $productColor . ' - only at ₹' . defaultVariant($this->variantData, false)['variant_sale_price'] . ' - ' . $productSubtype . ' for ' . $this->productData['product_gender'] . '  -  KidSuperStore.in';
        $keywords    = [
            $productName,
            $productSubtype,
            $this->productData['product_gender'],
            $this->productData['product_age_group'],
            $this->productData['product_category_type'],
            $this->productData['product_category_type'] . ' for ' . $this->productData['product_gender'],
            $productSubtype . ' for ' . $this->productData['product_gender'],
            'Buy ' . $productName . ' Online in India at best price only at KidSuperStore.in',
        ];
        $imgData = $this->productColor->getDefaultImage(['list-view']);
        $image   = (isset($this->productColor->getDefaultImage(['list-view'])['list-view'])) ? $this->productColor->getDefaultImage(['list-view'])['list-view']['1x'] : null;

        return [
            "title"               => $title,
            "description"         => $description,
            "og_title"            => $title,
            "og_description"      => $description,
            "og_image"            => $image,
            "twitter_title"       => $title,
            "twitter_description" => $description,
            "twitter_image"       => $image,
            "keywords"            => $keywords,
            "og_url"              => $url,
            "og_site_name"        => 'KidSuperStore.in',
            "twitter_site"        => 'KidSuperStore.in',
            "twitter_url"         => $url,
            "cannonical_url"      => $url,
        ];

    }

    public function getBlogsData()
    {

        return [];
    }

    private function getSizechartUrl()
    {
        $sizechart = SizechartImage::where('product_gender', $this->productData['product_gender'])->where('product_subtype', $this->productData['product_subtype'])->where('product_brand', $this->productData['product_brand'])->first();
        if (is_null($sizechart)) {
            return ['desktop' => null, 'mobile' => null];
        } else {
            return $sizechart->getAwsLinks();
        }

    }

    public function generateSinglePageData($objects)
    {
        $data = [];
        foreach ($objects as $object) {
            switch ($object) {
                case 'attributes':
                    $data['attributes'] = $this->getProductAttributes();
                    break;
                case 'facets':
                    $data['facets'] = $this->getProductFacets();
                    break;
                case 'variants':
                    $data['variants'] = $this->getVariants();
                    break;
                case 'images':
                    $data['images'] = $this->getImages();
                    break;
                case 'is_sellable':
                    $data['is_sellable'] = $this->isSellable();
                    break;
                case 'color_variants':
                    $data['color_variants'] = $this->getColorVariants();
                    break;
                case 'breadcrumbs':
                    $data['breadcrumbs'] = $this->getBreadcrumbs();
                    break;
                case 'related_products':
                    $data['related_products'] = $this->getSimilarProducts();
                    break;
                case 'meta':
                    $data['meta'] = $this->getSeoAttributes();
                    break;
                case 'size_chart':
                    $data['size_chart'] = $this->getSizechartUrl();
                    break;
                case 'blogs':
                    # code...
                    break;
                default:
                    throw new \Exception("object type " . $object . " not defined", 1);

                    break;
            }
        }
        return $data;
    }

}