<?php

namespace App;

use App\Defaults;
use App\Elastic\ElasticQuery;
use App\Elastic\OdooConnect;
use App\Jobs\CreateMoveJobs;
use App\Jobs\IndexMove;
use App\Jobs\IndexProduct;
use App\Jobs\UpdateVariantInventory;

class ProductMove
{
    public static function startSync()
    {
        $lastMove = Defaults::getLastProductMove();
        $offset   = 0;
        do {
            $moves = self::getMoveIDs(['id' => $lastMove], $offset);
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
        // dd($sanitisedData);
        $variant       = Variant::where('odoo_id', $sanitisedData['move_product_id'])->first();
        if ($variant == null) {
            \Log::notice('chaining product Move ' . $move_id . ' as variant ' . $sanitisedData['move_product_id'] . ' is not found in DB');
            IndexProduct::withChain([
                (new IndexMove($move_id))->onQueue('process_move'),
            ])->dispatch(Variant::getVariantProductIdFromOdoo($sanitisedData['move_product_id']))->onQueue('process_product');
            return;
        }
        $elastic_data = array_merge($sanitisedData, $variant->getVariantData('all', 'variant_'));
        $data         = self::indexElasticData($elastic_data);
        if (config('product.update_inventory')) {
            if ($sanitisedData["move_to_loc"] == "Stock" or $sanitisedData["move_from_loc"] == "Stock") {
                UpdateVariantInventory::dispatch([$elastic_data["move_product_id"]])->onQueue('update_inventory');
            }
        }

    }

    public static function indexElasticData($data)
    {
        $query = new ElasticQuery;
        $query->createIndexParams($data['move_id'], $data);
        $response = $query->setIndex(config('elastic.indexes.move'))->index();
        switch ($response['result']) {
            case 'created':
                \Log::info("Product Move {$response['_id']} indexed (Created)");
                break;
            case 'updated':
                \Log::info("Product Move {$response['_id']} indexed (Updated)");
                break;
            default:
                \Log::notice("Product Move {$response['_id']} status {$response['result']}");
                break;
        }
    }

}
