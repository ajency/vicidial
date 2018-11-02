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

    public static function updateElasticInventory(int $variant_id, array $elastic_data, boolean $availability)
    {
        foreach ($elastic_data["variants"] as &$variant) {
            if ($variant["variant_id"] == $variant_id) {
                $variant["variant_availability"] = $availability;
                break;
            }
        }

        foreach ($elastic_data["search_data"] as &$variant) {
            $flag = false;
            foreach ($variant["number_facet"] as $facet) {
                if ($facet["facet_name"] == "variant_id" and $facet["facet_value"] == $variant_id) {
                    $flag = true;
                    break;
                }
            }
            if ($flag) {

                foreach ($variant["boolean_facet"] as &$facet) {
                    if ($facet["facet_name"] == "variant_availability") {
                        $facet["facet_value"] = $availability;
                        break;
                    }
                }
                break;
            }
        }
        $result = self::saveToElastic($elastic_id, $elastic_data);
        return $result;
    }
}
