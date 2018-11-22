<?php

namespace App;

use Ajency\FileUpload\FileUpload;
use App\Elastic\ElasticQuery;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use FileUpload;

    public static function getElasticData(string $id)
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));
        return $q->get($id);
    }

    public static function saveToElastic(string $id, array $data)
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));
        $q->createIndexParams($id, $data);
        return $q->index();
    }

    private static function upateElasticResultData($elastic_data, $change, $is_variant, $variant_id)
    {
        if ($is_variant) {
            foreach ($elastic_data["variants"] as &$variant) {
                if ($variant["variant_id"] == $variant_id) {
                    foreach ($change as $facet_name => $attributes) {
                        foreach ($attributes as $key => $value) {
                            $variant[$key] = $value;
                        }
                    }
                    break;
                }
            }
        } else {
            foreach ($change as $facet_name => $attributes) {
                foreach ($attributes as $key => $value) {
                    $elastic_data['search_result_data'][$key] = $value;
                }
            }
        }
        return $elastic_data;
    }

    public static function updateElasticSearchData($elastic_data, $change, $is_variant, $variant_id)
    {
        foreach ($elastic_data["search_data"] as &$variant) {
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
                foreach ($change as $facet_name => $attributes) {
                    foreach ($variant[$facet_name] as &$facet) {
                        foreach ($attributes as $key => $value) {
                            if ($facet["facet_name"] == $key) {
                                $facet["facet_value"] = $availability;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return $elastic_data;
    }

    public static function updateElasticData(array $elastic_data, array $change, $skip_result = false, $is_variant = true, $variant_id = null)
    {
        if (!$skip_result) {
            $elastic_data = self::upateElasticResultData($elastic_data, $change, $is_variant, $variant_id);
        }
        $elastic_data = self::updateElasticSearchData($elastic_data, $change, $is_variant, $variant_id);
        dd($elastic_data);
        $result = self::saveToElastic($elastic_data['id'], $elastic_data);
        return $result;
    }
}
