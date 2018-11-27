<?php

namespace App;

use Ajency\FileUpload\FileUpload;
use App\Elastic\ElasticQuery;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\FetchProductImages;

class ProductColor extends Model
{
    use FileUpload;

    public function getElasticData()
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));
        return $q->get($this->elastic_id)['_source'];
    }

    public static function saveToElastic(string $id, array $data)
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));
        $q->createIndexParams($id, $data);
        return $q->index();
    }

    private static function updateElasticResultData($elastic_data, $change, $is_variant, $variant_id)
    {
        if ($is_variant) {
            foreach ($elastic_data["variants"] as &$variant) {
                if ($variant["variant_id"] == $variant_id) {
                    foreach ($change as $key => $value) {
                        $variant[$key] = $value;
                    }
                    break;
                }
            }
        } else {
            foreach ($change as $key => $value) {
                $elastic_data['search_result_data'][$key] = $value;
            }
        }
        return $elastic_data;
    }

    public static function updateElasticSearchData($elastic_data, $change, $is_variant, $variant_id)
    {
        foreach ($elastic_data['search_data'] as &$variant) {
            $flag = false;
            if ($is_variant) {
                foreach ($variant["number_facet"] as $facet) {
                    if ($facet["facet_name"] == "variant_id" and $facet["facet_value"] == $variant_id) {
                        $flag = true;
                        break;
                    }
                }
            } else {
                $flag = true;
            }
            if ($flag) {
                foreach ($change as $facet_type => $attributes) {
                    foreach ($variant[$facet_type] as $facet_key => $facet) {
                        if (isset($attributes[$facet["facet_name"]])) {
                            $variant[$facet_type][$facet_key]["facet_value"] = $attributes[$facet["facet_name"]];
                        }
                    }
                }
            }
        }
        return $elastic_data;
    }

    public static function updateElasticData(array $elastic_data, array $change, $is_variant = true, $variant_id = null)
    {
        if (isset($change['result'])) {
            $elastic_data = self::updateElasticResultData($elastic_data, $change['result'], $is_variant, $variant_id);
        }
        if (isset($change['search'])) {
            $elastic_data = self::updateElasticSearchData($elastic_data, $change['search'], $is_variant, $variant_id);
        }
        \Log::debug($elastic_data);
        $result = self::saveToElastic($elastic_data['id'], $elastic_data);
        return $result;
    }
}
