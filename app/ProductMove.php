<?php

namespace App;

use App\Defaults;
use App\Elastic\OdooConnect;
use App\Jobs\CreateMoveJobs;
use App\Elastic\ElasticQuery;

class ProductMove
{
    public function startSync()
    {
        $lastMove = Defaults::getLastProductMove();
        $offset   = 0;
        do {
            $moves = self::getProductIDs(['id' => $lastMove], $offset);
            CreateMoveJobs::dispatch($moves)->onQueue('create_jobs');
            $offset = $offset + $moves->count();
        } while ($moves->count() == config('odoo.limit'));
    }

    public static function getMoveIDs($filters, $offset, $limit = false)
    {
        $odooFilter = OdooConnect::odooFilter($filters);
        $odoo       = new OdooConnect;
        $attributes = ['order' => 'id', 'offset' => $offset];
        if ($limit) {
            $attributes['limit'] = $limit;
        }

        $moves = $odoo->defaultExec('stock.move.line', 'search', $odooFilter, $attributes);

        Defaults::setLastProductMove($moves->last());
        return $moves;
    }

    public static function indexProductMove($move_id)
    {
        $odoo          = new OdooConnect;
        $moveData      = $odoo->defaultExec('stock.move.line', 'read', [[$move_id]], ['fields' => config('product.move_fields')])->first();
        $sanitisedData = sanitiseMoveData($moveData, 'move_');
        $elastic_data  = array_merge($sanitisedData, Variant::where('odoo_id', $sanitisedData['move_product_id'])->first()->getVariantData('all', 'variant_'));
        $data = self::indexElasticData($elastic_data);
        return $data;
    }

    public static function indexElasticData($data)
    {
        $query = new ElasticQuery;
        $query->createIndexParams($data['move_id'],$data);
        return $query->setIndex(config('elastic.indexes.move'))->index();
    }

}
