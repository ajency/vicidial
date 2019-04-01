<?php

namespace App;

use Ajency\Connections\ElasticQuery;
use Ajency\FileUpload\FileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SizechartImage extends Model
{
    use FileUpload;

    protected $fillable = ['product_gender', 'product_subtype', 'product_brand'];
    protected $casts    = ['aws_links' => 'array'];

    public function getSizechartImageUrlByType($image_type)
    {
        $config      = config('ajfileupload');
        $newFilePath = "";
        $photo       = $this->photos()->where('type', $image_type)->first();
        // dd($this->photos);
        // print_r($photo);
        if ($photo) {
            $path        = explode('amazonaws.com/', $photo->file->url);
            $newFilePath = $path[1];
            if ($config['use_cdn'] && $config['cdn_url']) {
                $tempUrl     = parse_url($newFilePath);
                $newFilePath = $config['cdn_url'] . $tempUrl['path'];
            }
        }
        return $newFilePath;
    }

    public function getAwsLinks()
    {
        $links = [];

        if (isset($this->aws_links['desktop'])) {
            if (config('ajfileupload.use_cdn') && config('ajfileupload.cdn_url')) {
                $links['desktop'] = config('ajfileupload.cdn_url') . '/' . $this->aws_links['desktop'];
            } else {
                $links['desktop'] = \Storage::disk(config('ajfileupload.disk_name'))->url($this->aws_links['desktop']);
            }
        } else {
            $links['desktop'] = null;
        }
        if (isset($this->aws_links['mobile'])) {
            if (config('ajfileupload.use_cdn') && config('ajfileupload.cdn_url')) {
                $links['mobile'] = config('ajfileupload.cdn_url') . '/' . $this->aws_links['mobile'];
            } else {
                $links['mobile'] = \Storage::disk(config('ajfileupload.disk_name'))->url($this->aws_links['mobile']);
            }
        } else {
            $links['mobile'] = null;
        }
        return $links;
    }

    public function clearCache()
    {
        $q = new ElasticQuery;
        $q->setIndex(config("elastic.indexes.product"));

        $defaultFilters['primary_filter'] = ['product_gender' => $this->product_gender, 'product_subtype' => $this->product_subtype, 'product_brand' => $this->product_brand];

        $mustFilter = setElasticFacetFilters($q, ['search_object' => $defaultFilters], false)[0];
        $filters    = $q::addToBoolQuery('must', $mustFilter);
        $query      = $q::createNested("search_data", $filters);
        $q->setQuery($query)->setSource(['search_result_data.product_slug']);

        $products = $q->search()['hits']['hits'];

        foreach ($products as $product) {
            Cache::forget('single-product-' . $product['_source']['search_result_data']['product_slug']);
        }
    }
}
