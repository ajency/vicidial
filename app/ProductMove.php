<?php

namespace App;

use App\Defaults;
use App\Elastic\ElasticQuery;
use App\Elastic\OdooConnect;
use App\Jobs\CreateMoveJobs;
use App\Jobs\UpdateVariantInventory;
use App\Jobs\IndexAlternateMoves;

class ProductMove
{
    public static function startSync()
    {
        $lastMove = Defaults::getLastProductMoveSync();
        $offset   = 0;
        do {
            $moves = self::getMoveIDs(['write' => $lastMove], $offset);
            CreateMoveJobs::dispatch($moves)->onQueue('create_jobs');
            $offset = $offset + $moves->count();
        } while ($moves->count() == config('odoo.limit'));
        Defaults::setLastProductMoveSync();
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
        return $moves;
    }

    public static function indexProductMove($move_id)
    {
        $odoo          = new OdooConnect;
        $moveData      = $odoo->defaultExec('stock.move.line', 'read', [[$move_id]], ['fields' => config('product.move_fields')])->first();
        $sanitisedData = sanitiseMoveData($moveData, 'move_');
        $data         = self::indexElasticData($sanitisedData);
        if (config('product.update_inventory')) {
            if ($sanitisedData["move_to_loc"] == "Stock" or $sanitisedData["move_from_loc"] == "Stock") {
                UpdateVariantInventory::dispatch([$sanitisedData["move_product_id"]])->onQueue('update_inventory');
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

    public static function syncMovesToIndex($index, $start, $end)
    {
        IndexAlternateMoves::dispatch($index, $start, $end)->onQueue('process_move');
    }

    public static function indexMoves($index, $start, $end)
    {
        $odooFilter    = OdooConnect::odooFilter(['id_range' => [$start, $end]]);
        $odoo          = new OdooConnect;
        $attributes    = ['order' => 'id', 'fields' => config('product.move_fields')];
        $moves         = $odoo->defaultExec('stock.move.line', 'search_read', $odooFilter, $attributes);
        $sanitisedData = collect();
        $moves->each(function ($item, $key) use ($sanitisedData) {
            $sanitisedData->push(sanitiseMoveData($item, 'move_'));
        });
        self::bulkIndexProductMoves($index, $sanitisedData);
        if($moves->count()  == config('odoo.limit') && $moves->last()['id'] < $end ){
            IndexAlternateMoves::dispatch($index,$moves->last()['id']+1,$end)->onQueue('process_move');
            // self::indexMoves($index,$moves->last()['id']+1,$end);
        }
    }

    public static function bulkIndexProductMoves($index, $moves)
    {
        $query = new ElasticQuery;
        $query->setIndex($index);
        $query->initializeBulkIndexing();
        $moves->each(function ($item, $key) use ($query) {
            $query->addToBulkIndexing($item['move_id'], $item);
        });
        $responses = $query->bulk();
        foreach ($responses['items'] as $response) {
            switch ($response['index']['result']) {
                case 'created':
                    \Log::info("Product Move {$response['index']['_id']} created");
                    break;
                case 'updated':
                    \Log::info("Product Move {$response['index']['_id']} updated");
                    break;
                default:
                    \Log::notice("Product {$response['index']['_id']} status {$response['index']['result']}");
                    break;
            }
        }
    }

}
