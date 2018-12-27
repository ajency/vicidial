<?php

namespace App;

use Ajency\FileUpload\FileUpload;
use App\Elastic\ElasticQuery;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\FetchProductImages;
use SoapBox\Formatter\Formatter;
use Illuminate\Support\Facades\Storage;

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

    public static function productXMLData()
    {
        $productColors = self::get();
        $xmlData       = array();
        foreach ($productColors as $productColor) {
            try {
                $productColorData = $productColor->getElasticData();
            } catch (\Exception $e) {
                continue;
            }

            $images     = $productColor->getAllImages(["main"]);
            $main_image = (isset($images['main'])) ? $images['main'] : false;

            $params = [
                'id'                => $productColorData['id'],
                'title'             => $productColorData['search_result_data']['product_title'],
                'age_group'         => $productColorData['search_result_data']['product_age_group'],
                'color'             => $productColorData['search_result_data']['product_color_name'],
                'gender'            => ($productColorData['search_result_data']['product_gender'] == 'Boys') ? 'male' : (($productColorData['search_result_data']['product_gender'] == 'Girls') ? 'female' : 'unisex'),
                'identifier_exists' => 'no',
                'link'              => url('/') . "/" . $productColorData['search_result_data']['product_slug'] . "/buy",
            ];

            if ($productColorData['search_result_data']['product_description'] != false) {
                $params['description'] = $productColorData['search_result_data']['product_description'];
            }

            if ($productColorData['search_result_data']['product_att_material'] != false) {
                $params['material'] = $productColorData['search_result_data']['product_att_material'];
            }

            if ($productColorData['search_result_data']['product_image_available'] != false && $main_image != false) {
                $params['image_link'] = $main_image;
            }

            $params['sale_price']   = $productColorData["variants"][0]["variant_sale_price"];
            $params['price']        = $productColorData["variants"][0]["variant_list_price"];
            $params['availability'] = "out of stock";
            $params['size']         = "";
            $sizes                  = array();

            foreach ($productColorData["variants"] as $key => $variant) {
                if ($params['sale_price'] > $variant["variant_sale_price"]) {
                    $params['sale_price'] = $variant["variant_sale_price"];
                    $params['price']      = $variant["variant_list_price"];
                }
                if ($params['availability'] == "in stock" || $variant['variant_availability'] == true) {
                    $params['availability'] = "in stock";
                }
                array_push($sizes, $variant["variant_size_name"]);
            }

            $params['size'] = implode('/', $sizes);

            array_push($xmlData, $params);
        }

        $formatter = Formatter::make($xmlData, Formatter::ARR);
        $xml       = $formatter->toXml();

        Storage::disk('s3')->put(config('ajfileupload.doc_base_root_path').'/products.xml', $xml);
    }
}
