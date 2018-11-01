<?php

namespace App;

use Ajency\FileUpload\FileUpload;
use Illuminate\Database\Eloquent\Model;
use App\Elastic\ElasticQuery;

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
}
