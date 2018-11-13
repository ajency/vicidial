<?php

namespace App;

use App\Defaults;
use App\Elastic\OdooConnect;
use App\Jobs\CreateMoveJobs;

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
}
