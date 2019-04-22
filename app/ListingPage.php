<?php

namespace App;

use Ajency\Connections\ElasticQuery;
use App\Facet;
use App\SingleProduct;
use Illuminate\Support\Facades\Cache;

class ListingPage
{
    protected static $facets;
    protected $params, $elastic_data, $search_string, $sort_on;
    protected $primary_filters, $primary_filter_keys, $primary_base_filters, $primary_base_filter_keys, $boolean_filters, $boolean_filter_keys, $range_filters, $range_filter_keys;

    public function __construct($params)
    {
        if (is_null(self::$facets)) {
            self::$facets = Facet::select(['facet_name', 'facet_value', 'display_name', 'slug', 'sequence'])->get();
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

    private function getSearchString()
    {
        return $this->search_string;
    }
}
