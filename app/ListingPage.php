<?php

namespace App;

use Ajency\Connections\ElasticQuery;
use App\Facet;
use App\SingleProduct;
use Illuminate\Support\Facades\Cache;

class ListingPage
{
    protected static $facets;
    protected $params, $elastic_data, $elastic_filters, $search_string, $sort_on;
    protected $primary_filters, $primary_filter_keys, $primary_base_filters, $primary_base_filter_keys, $boolean_filters, $boolean_filter_keys, $range_filters, $range_filter_keys;

    public function __construct($params)
    {
        if (is_null(self::$facets)) {
            self::$facets = Facet::select(['facet_name', 'facet_value', 'display_name', 'slug', 'sequence', 'display'])->get();
        }

        $this->primary_filters = array_filter(config('product.facet_display_data'), function ($value) {
            return ($value['filter_type'] == 'primary_filter');
        });
        $this->primary_filter_keys = array_combine(array_column($this->primary_filters, "attribute_param"), array_keys($this->primary_filters));

        $this->primary_base_filters = array_filter($this->primary_filters, function ($value) {
            return ($value['is_attribute_param'] == false);
        });
        $this->primary_base_filter_keys = array_combine(array_column($this->primary_base_filters, "attribute_param"), array_keys($this->primary_base_filters));

        $this->boolean_filters = array_filter(config('product.facet_display_data'), function ($value) {
            return ($value['filter_type'] == 'boolean_filter');
        });
        $this->boolean_filter_keys = array_combine(array_column($this->boolean_filters, "attribute_param"), array_keys($this->boolean_filters));

        $this->range_filters = array_filter(config('product.facet_display_data'), function ($value) {
            return ($value['filter_type'] == 'range_filter');
        });
        $this->range_filter_keys = array_combine(array_column($this->range_filters, "attribute_param"), array_keys($this->range_filters));

        $this->setParams($params);
    }

    private function setParams($params)
    {
        $param_arr                  = [];
        $param_arr['search_object'] = [];
        if (isset($params['pf'])) {
            $param_arr['search_object']['primary_filter'] = [];
            foreach ($params['pf'] as $slugs) {
                $slugs_arr = explode('--', $slugs);
                $pf        = self::$facets->whereIn('facet_name', array_keys($this->primary_base_filters))->whereIn('slug', $slugs_arr);
                if ($pf->count() != count($slugs_arr) || $pf->groupBy('facet_name')->count() != 1) {
                    abort(404, "pf not valid");
                }
                $facet_name = $pf->first()->facet_name;
                if (isset($param_arr['search_object']['primary_filter'][$facet_name])) {
                    abort(404, "pf not valid");
                }
                $param_arr['search_object']['primary_filter'][$facet_name] = [];
                foreach ($pf as $facet) {
                    $param_arr['search_object']['primary_filter'][$facet_name][] = $facet->facet_value;
                }
            }
        }
        foreach ($this->primary_filter_keys as $param_key => $facet_name) {
            if (isset($params[$param_key])) {
                if (!isset($param_arr['search_object']['primary_filter'])) {
                    $param_arr['search_object']['primary_filter'] = [];
                }
                $pf = self::$facets->where('facet_name', $facet_name)->whereIn('slug', $params[$param_key]);
                if ($pf->count() != count($params[$param_key])) {
                    abort(404, $param_key . " not valid");
                }
                $param_arr['search_object']['primary_filter'][$facet_name] = [];
                foreach ($pf as $facet) {
                    $param_arr['search_object']['primary_filter'][$facet_name][] = $facet->facet_value;
                }
            }
        }
        foreach ($this->boolean_filter_keys as $param_key => $facet_name) {
            if (isset($params[$param_key])) {
                if (!isset($param_arr['search_object']['boolean_filter'])) {
                    $param_arr['search_object']['boolean_filter'] = [];
                }
                switch ($params[$param_key]) {
                    case 'true':
                        $param_arr['search_object']['boolean_filter'][$facet_name] = true;
                        break;

                    case 'false':
                        $param_arr['search_object']['boolean_filter'][$facet_name] = false;
                        break;

                    case 'skip':
                        $param_arr['search_object']['boolean_filter'][$facet_name] = 'skip';
                        break;

                    default:
                        abort(404, $param_key . " not valid");
                        break;
                }
            }
        }
        foreach ($this->range_filter_keys as $param_key => $facet_name) {
            if (isset($params[$param_key])) {
                if (!isset($param_arr['search_object']['range_filter'])) {
                    $param_arr['search_object']['range_filter'] = [];
                }
                if (!isset($params[$param_key]['min']) || !isset($params[$param_key]['max']) || count($params[$param_key]) != 2) {
                    abort(404, $param_key . " not valid");
                }

                $param_arr['search_object']['range_filter'][$facet_name] = $params[$param_key];
            }
        }
        if (isset($params['search_string'])) {
            $param_arr['search_object']['search_string'] = $params['search_string'];
            $this->search_string                         = $params['search_string'];
        }
        if (isset($params['sort_on'])) {
            $param_arr['sort_on'] = $params['sort_on'];
            $this->sort_on        = $params['sort_on'];
        }
        if (isset($params['page'])) {
            $param_arr['page'] = $params['page'];
        } else {
            $param_arr['page'] = 1;
        }
        $param_arr['display_limit'] = config('product.list_page_display_limit');

        $this->params = $param_arr;
    }

    public function generateSinglePageData($objects)
    {
        $data = [];
        foreach ($objects as $object) {
            switch ($object) {
                case 'items':
                    $data['items'] = $this->getItems();
                    break;
                case 'page':
                    $data['page'] = $this->getItemCount();
                    break;
                case 'headers':
                    $data['headers'] = $this->getTitle();
                    break;
                case 'results_found':
                    $data['results_found'] = $this->getResultsFoundBoolean();
                    break;
                case 'breadcrumbs':
                    $data['breadcrumbs'] = $this->getBreadcrumbs();
                    break;
                case 'filters_with_count':
                    $data['filters'] = $this->getFiltersWithCount();
                    break;
                case 'filters_without_count':
                    $data['filters'] = $this->getFiltersWithoutCount();
                    break;
                case 'search_string':
                    $data['search_string'] = $this->getSearchString();
                    break;
                case 'sort_on':
                    $data['sort_on'] = $this->getSortOn();
                    break;
                default:
                    throw new \Exception("object type " . $object . " not defined", 1);

                    break;
            }
        }
        return $data;
    }

    private function getElasticData()
    {
        if (is_null($this->elastic_data)) {
            $this->getItemsWithFilters();
        }
        return $this->elastic_data;
    }

    private function getItemsWithFilters()
    {
        $params                  = $this->params;
        $params['search_object'] = setDefaultFilters($params);
        $size                    = $params["display_limit"];
        $offset                  = ($params["page"] - 1) * $size;
        $index                   = config('elastic.indexes.product');
        $q                       = new ElasticQuery;
        $q->setIndex($index);
        $must = setElasticFacetFilters($q, $params);
        $q->setQuery($must)
            ->setSource(["search_result_data.product_slug"])
            ->setSize($size)->setFrom($offset);
        if (isset($params['sort_on']) and $params['sort_on'] != "") {
            $sort = config('product.sort.' . $params['sort_on']);
            $q->setSort([$sort['field'] => ['order' => $sort['order']]]);
        } else {
            $sort = config('product.sort.rank_desc');
            $q->setSort([$sort['field'] => ['order' => $sort['order']]]);
        }
        $this->elastic_data = formatItems($q->search(), $params);
    }

    private function getItems()
    {
        $items = [];
        foreach ($this->getElasticData()["items"] as $slug) {
            $apiResponse = Cache::rememberForever('list-product-' . $slug, function () use ($slug) {
                $singleProduct = new SingleProduct($slug);
                $apiResponse   = $singleProduct->generateSinglePageData(['attributes', 'facets', 'variants', 'images', 'is_sellable']);
                return $apiResponse;
            });
            array_push($items, $apiResponse);
        }
        return $items;
    }

    private function getItemCount()
    {
        return $this->getElasticData()["page"];
    }

    private function getTitle()
    {
        return ['page_title' => generateProductListTitle($this->params['search_object'], self::$facets->groupBy('facet_name')), 'product_count' => $this->getElasticData()["page"]["total_item_count"]];
    }

    private function getResultsFoundBoolean()
    {
        return $this->getElasticData()["results_found"];
    }

    private function getBreadcrumbs()
    {
        return [];
    }

    private function getElasticFilters()
    {
        if (is_null($this->elastic_filters)) {
            $this->getFilterCounts();
        }
        return $this->elastic_filters;
    }

    private function buildBaseQuery($variant_availability = "skip")
    {
        $q = new ElasticQuery;

        $max_count = self::$facets->groupBy('facet_name')->max()->count();

        $variants_required = ["variant_size_name"];
        $required          = array_values(array_diff(array_keys($this->primary_filters), $variants_required));

        $aggs_facet_name   = $q::createAggTerms("facet_name", "search_data.string_facet.facet_name", ["include" => $required]);
        $aggs_facet_value  = $q::createAggTerms("facet_value", "search_data.string_facet.facet_value", ["size" => $max_count]);
        $aggs_facet_value  = $q::addToAggregation($aggs_facet_value, $q::createAggReverseNested('count'));
        $aggs_facet_name   = $q::addToAggregation($aggs_facet_name, $aggs_facet_value);
        $aggs_string_facet = $q::createAggNested("agg_string_facet", "search_data.string_facet");
        $aggs_string_facet = $q::addToAggregation($aggs_string_facet, $aggs_facet_name);

        $aggFacetNameP = $q::createAggTerms("facet_name", "search_data.number_facet.facet_name", ["include" => ['variant_sale_price']]);
        $aggMax        = $q::createAggMax('facet_value_max', 'search_data.number_facet.facet_value');
        $aggMin        = $q::createAggMin('facet_value_min', 'search_data.number_facet.facet_value');
        $minMax        = $q::addToAggregation($aggFacetNameP, array_merge($aggMax, $aggMin));
        $aggsPrice     = $q::createAggNested("agg_price", "search_data.number_facet");
        $priceQ        = $q::addToAggregation($aggsPrice, $minMax);

        $facet_names = [];

        foreach ($variants_required as $facet_name) {
            $reverse          = $q::createAggReverseNested('count');
            $size             = $q::createAggTerms($facet_name, "variants." . $facet_name, ["size" => $max_count]);
            $aggs_facet_value = $q::addToAggregation($size, $reverse);
            $facet_names      = $facet_names + $aggs_facet_value;
        }

        if ($variant_availability === "skip") {
            $filterAgg = $q::createAggFilter("available", ["match_all" => new \stdClass()]);
        } else {
            $filterAgg = $q::createAggFilter("available", ["term" => ["variants.variant_availability" => $variant_availability]]);
        }

        $facet_name = $q::addToAggregation($filterAgg, $facet_names);
        $nestedAgg  = $q::createAggNested("variant_aggregation", "variants");
        $aggs       = $q::addToAggregation($nestedAgg, $facet_name);

        $q->setIndex(config('elastic.indexes.product'))
            ->initAggregation()->setAggregation(array_merge($priceQ, $aggs_string_facet, $aggs))
            ->setSize(0);

        return $q;
    }

    private function getFilterCounts()
    {
        $params                  = setListingFilters($this->params);
        $params['search_object'] = setDefaultFilters($params);
        $available               = "skip";
        if (isset($params['search_object']['boolean_filter']['variant_availability'])) {
            $available = $params['search_object']['boolean_filter']['variant_availability'];
        }

        $q    = self::buildBaseQuery($available);
        $must = setElasticFacetFilters($q, $params);
        $q->setQuery($must);
        $response              = $q->search();
        $this->elastic_filters = sanitiseFilterdata($response);
    }

    private function getPrimaryFilterItems($facet_name, $count)
    {
        $items       = [];
        $facet_items = self::$facets->where('facet_name', $facet_name);
        foreach ($facet_items as $facet) {
            array_push($items, [
                "facet_value"       => $facet['facet_value'],
                "false_facet_value" => null,
                "display_name"      => $facet['display_name'],
                "slug"              => $facet['slug'],
                "display"           => $facet['display'],
                "sequence"          => $facet['sequence'],
                "is_selected"       => ($count) ? (isset($this->params['search_object']['primary_filter'][$facet_name]) && in_array($facet['facet_value'], $this->params['search_object']['primary_filter'][$facet_name])) ? true : false : null,
                "count"             => ($count) ? (isset($this->getElasticFilters()[$facet_name][$facet['facet_value']])) ? $this->getElasticFilters()[$facet_name][$facet['facet_value']] : 0 : null,
            ]);
        }
        return $items;
    }

    private function getPrimaryFilters($count)
    {
        $filters = [];
        foreach ($this->primary_filters as $facet_name => $facet_config) {
            $item_data                           = [];
            $item_data['header']                 = ['facet_name' => $facet_name, 'display_name' => $facet_config['name']];
            $item_data["is_singleton"]           = $facet_config['is_singleton'];
            $item_data["is_collapsed"]           = $facet_config['is_collapsed'];
            $item_data["display"]                = $facet_config['display'];
            $item_data["attribute_param"]        = $facet_config['attribute_param'];
            $item_data["order"]                  = $facet_config['order'];
            $item_data["display_count"]          = $facet_config['display_count'];
            $item_data["disabled_at_zero_count"] = $facet_config['disabled_at_zero_count'];
            $item_data["is_attribute_param"]     = $facet_config['is_attribute_param'];
            $item_data["filter_type"]            = $facet_config['filter_type'];
            $item_data["sort_on"]                = $facet_config['sort_on'];
            $item_data["sort_order"]             = $facet_config['sort_order'];
            $item_data["items"]                  = $this->getPrimaryFilterItems($facet_name, $count);
            array_push($filters, $item_data);
        }
        return $filters;
    }

    private function getRangeFilters($count)
    {
        $filters = [];
        foreach ($this->range_filters as $facet_name => $facet_config) {
            $item_data                           = [];
            $item_data['header']                 = ['facet_name' => $facet_name, 'display_name' => $facet_config['name']];
            $item_data["is_singleton"]           = $facet_config['is_singleton'];
            $item_data["is_collapsed"]           = $facet_config['is_collapsed'];
            $item_data["display"]                = $facet_config['display'];
            $item_data["attribute_param"]        = $facet_config['attribute_param'];
            $item_data["order"]                  = $facet_config['order'];
            $item_data["display_count"]          = $facet_config['display_count'];
            $item_data["disabled_at_zero_count"] = $facet_config['disabled_at_zero_count'];
            $item_data["is_attribute_param"]     = $facet_config['is_attribute_param'];
            $item_data["filter_type"]            = $facet_config['filter_type'];
            $item_data["sort_on"]                = $facet_config['sort_on'];
            $item_data["sort_order"]             = $facet_config['sort_order'];
            $item_data["items"]                  = [];
            $item_data["bucket_range"]           = ['start' => $facet_config['range']['min'], 'end' => $facet_config['range']['max']];
            $item_data["selected_range"]         = ($count) ? (isset($this->params['search_object']['range_filter'][$facet_name])) ? ['start' => $this->params['search_object']['range_filter'][$facet_name]['min'], 'end' => $this->params['search_object']['range_filter'][$facet_name]['max']] : ['start' => $facet_config['range']['min'], 'end' => $facet_config['range']['max']] : ['start' => $facet_config['range']['min'], 'end' => $facet_config['range']['max']];
            array_push($filters, $item_data);
        }
        return $filters;
    }

    private function getBooleanFilters($count)
    {
        $filters = [];
        foreach ($this->boolean_filters as $facet_name => $facet_config) {
            $item_data                           = [];
            $item_data['header']                 = ['facet_name' => $facet_name, 'display_name' => $facet_config['name']];
            $item_data["is_singleton"]           = $facet_config['is_singleton'];
            $item_data["is_collapsed"]           = $facet_config['is_collapsed'];
            $item_data["display"]                = $facet_config['display'];
            $item_data["attribute_param"]        = $facet_config['attribute_param'];
            $item_data["order"]                  = $facet_config['order'];
            $item_data["display_count"]          = $facet_config['display_count'];
            $item_data["disabled_at_zero_count"] = $facet_config['disabled_at_zero_count'];
            $item_data["is_attribute_param"]     = $facet_config['is_attribute_param'];
            $item_data["filter_type"]            = $facet_config['filter_type'];
            $item_data["sort_on"]                = $facet_config['sort_on'];
            $item_data["sort_order"]             = $facet_config['sort_order'];
            $item_data["items"]                  = [[
                "display_name"      => $facet_config['item_display_name'],
                "facet_value"       => $facet_config['facet_value'],
                "false_facet_value" => $facet_config['false_facet_value'],
                "slug"              => $facet_config['facet_value'],
                "display"           => $facet_config['display'],
                "is_selected"       => ($count) ? (isset($this->params['search_object']['boolean_filter'][$facet_name]) && $this->params['search_object']['boolean_filter'][$facet_name] == $facet_config['facet_value']) ? true : false : null,
            ]];
            array_push($filters, $item_data);
        }
        return $filters;
    }

    private function getFiltersWithoutCount()
    {
        $primary_filters = $this->getPrimaryFilters(false);
        $range_filters   = $this->getRangeFilters(false);
        $boolean_filters = $this->getBooleanFilters(false);
        return array_merge($primary_filters, $range_filters, $boolean_filters);
    }

    private function getFiltersWithCount()
    {
        $primary_filters = $this->getPrimaryFilters(true);
        $range_filters   = $this->getRangeFilters(true);
        $boolean_filters = $this->getBooleanFilters(true);
        return array_merge($primary_filters, $range_filters, $boolean_filters);
    }

    private function getSearchString()
    {
        return $this->search_string;
    }

    private function getSortOn()
    {
        $sort_on = [];
        foreach (config('product.sort_on') as $sort_items) {
            array_push($sort_on, [
                "name"        => $sort_items['name'],
                "value"       => $sort_items['value'],
                "is_selected" => ($this->sort_on) ? ($this->sort_on == $sort_items['value']) ? true : false : $sort_items['is_selected'],
                "class"       => $sort_items['class'],
            ]);
        }
        return $sort_on;
    }

    public function clearListFilterCache()
    {
        Cache::forget('list-filters');
    }
}
