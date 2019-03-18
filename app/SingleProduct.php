<?php

namespace App;

use Ajency\Connections\ElasticQuery;

class SingleProduct
{
    protected $productData, $variantData;

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
            self::$facets = Facet::select(['facet_name', 'facet_value', 'display_name', 'slug'])->get();
        }
        $this->setSlugElasticData($slug);

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

    private function getVariantAttributes($variant){
    	$attributes = [];
        foreach (self::VARIANT_ATTRIBUTES as $attribute_name) {
            $attributes[$attribute_name] = (isset($variant[$attribute_name])) ? $variant[$attribute_name] : "";
        }
        return $attributes;
    }

    private function getVariantFacets($variant){
    	return [];
    }

    private function getVariants($which){
    	$variants = [];
    	$defaultId = defaultVariant($this->variantData);
    	foreach ($this->variantData as $variant) {
    		$variantInfo = [];
    		$variantInfo['attributes'] = $this->getVariantAttributes($variant);
    		$variantInfo['facets'] = $this->getVariantFacets($variant);
    		$variantInfo['is_default'] = $defaultId == $variant['variant_id'];
    		$variants[] = $variantInfo;
    	}
    	return $variants;
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
                	$data['variants'] = $this->getVariants([]);
                	break;
                default:
                    throw new \Exception("object type " . $object . " not defined", 1);

                    break;
            }
        }
        return $data;
    }

}
