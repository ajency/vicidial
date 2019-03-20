<?php

namespace App;

use Ajency\Connections\ElasticQuery;
use App\ProductColor;

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

    private function getColorVariants()
    {
        $colorVariants = [];
        $q             = new ElasticQuery;
        $q->setIndex(config("elastic.indexes.product"));
        $productID  = $this->productData['product_id'];
        $colorId    = $this->productData['product_color_id'];
        $facetName  = $q::createTerm('search_data.number_facet.facet_name', "product_id");
        $facetValue = $q::createTerm('search_data.number_facet.facet_value', $productID);
        $must       = $q::addToBoolQuery('must', [$facetName, $facetValue]);
        $nested     = $q::createNested('search_data.number_facet', $must);
        $q->setQuery($nested)->setSource(['search_result_data']);
        $colorVariantsData = $q->search()['hits']['hits'];
        foreach ($colorVariantsData as $cved) {
            $cvd                         = $cved['_source']['search_result_data'];
            $colorVariant                = [];
            $facetData                   = self::$facets->where('facet_name', 'product_color_html')->where('facet_value', $cvd['product_color_html'])->first();
            $colorVariant['color_id']    = $cvd['product_color_id'];
            $colorVariant['color_name']  = $facetData['display_name'];
            $colorVariant['image']       = ProductColor::where('product_id', $productID)->where('color_id', $cvd['product_color_id'])->first()->getDefaultImage(["variant-thumb"])["variant-thumb"];
            $colorVariant['url']         = url('/' . $cvd['product_slug'] . '/buy');
            $colorVariant['is_selected'] = $cvd['product_color_id'] == $colorId;
            $colorVariant['hexcode']     = $facetData['slug'];
            $colorVariants[]             = $colorVariant;
        }
        return $colorVariants;
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
                default:
                    throw new \Exception("object type " . $object . " not defined", 1);

                    break;
            }
        }
        return $data;
    }

}
