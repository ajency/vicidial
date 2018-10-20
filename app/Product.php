<?php
namespace App;

use App\Elastic\ElasticQuery;
use App\Elastic\OdooConnect;
use App\Jobs\CreateProductJobs;

class Product
{
    protected $data;

    public static function getLastSyncedProduct()
    {
        // $query      = new ElasticQuery;
        // $lastSynced = intval($query->appendMust(ElasticQuery::createMatch('type', 'product'))
        //         ->setAggregation(ElasticQuery::createAggMax('max_id', 'id'))
        //         ->search()['aggregations']['max_id']['value']);
        // return $lastSynced;
        return 0;
    }

    public static function odooFilter($filters)
    {
        if (isset($filters['id'])) {
            return [[['id', '>', $filters['id']]]];
        } elseif (isset($filters['created'])) {
            return [[['create_date', '>', $filters['created']]]];
        } elseif (isset($filters['updated'])) {
            return [[['__last_update', '>', $filters['updated']]]];
        } elseif (isset($filters['write'])) {
            return [[['write_date', '>', $filters['write']]]];
        }
    }

    public static function getProductIDs($filters, $offset, $limit = false)
    {
        $odooFilter = self::odooFilter($filters);
        $odoo       = new OdooConnect;
        $attributes = ['order' => 'id', 'offset' => $offset];
        if ($limit) {
            $attributes['limit'] = $limit;
        }

        $products = $odoo->defaultExec('product.template', 'search', $odooFilter, $attributes);
        return $products;
    }

    public static function startSync()
    {
        $first_id = self::getLastSyncedProduct();
        $offset   = 0;
        do {
            $products = self::getProductIDs(['id' => $first_id], $offset);
            CreateProductJobs::dispatch($products)->onQueue('create_jobs');
            // createJob1($products);
            $offset = $offset + $products->count();
        } while ($products->count() == config('odoo.limit'));
    }

    public static function indexProduct($product_id)
    {
        $odoo        = new OdooConnect;
        $productData = $odoo->defaultExec('product.template', 'read', [[$product_id]], ['fields' => config('product.template_fields')])->first();
        $products    = self::indexVariants($productData['product_variant_ids'], sanitiseProductData($productData));
        self::bulkIndexProducts($products);
    }

    public static function indexVariants($variant_ids, $productData)
    {
        $products     = collect();
        $odoo         = new OdooConnect;
        $variants     = collect();
        $variantsData = $odoo->defaultExec("product.product", 'read', [$variant_ids], ['fields' => config('product.variant_fields')]);
        foreach ($variantsData as $variantData) {
            $attributeValues = $odoo->defaultExec('product.attribute.value', 'read', [$variantData['attribute_value_ids']], ['fields' => config('product.attribute_fields')]);
            $variants->push(sanitiseVariantData($variantData, $attributeValues));
        }
        $colorvariants = $variants->groupBy('variant_color_id');
        foreach ($colorvariants as $colorVariantData) {
            $products->push(buildProductIndexFromOdooData($productData, $colorVariantData));
        }
        return $products;
    }

    public static function bulkIndexProducts($products)
    {
        $query = new ElasticQuery;
        $query->setIndex('product');
        $query->initializeBulkIndexing();
        $products->each(function ($item, $key) use ($query) {
            $query->addToBulkIndexing($item['id'], $item, ['op_type' => "create"]);
        });
        $responses = $query->bulk();
        $updated   = 0;
        foreach ($responses['items'] as $response) {
            switch ($response['create']['status']) {
                case 201:
                    $updated++;
                    \Log::info("Product {$response['create']['_id']} indexed");
                    break;

                default:
                    \Log::notice("Product {$response['create']['_id']} status {$response['create']['status']}");
                    break;
            }
        }
    }
}