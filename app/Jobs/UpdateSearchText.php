<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Elastic\ElasticQuery;
use App\Product;

class UpdateSearchText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productIDs,$indexName)
    {
        $this->index = $indexName;
        $this->products = $productIDs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $elastic = new ElasticQuery;
        $data = $elastic->setIndex($this->index)->mget($this->productIDs);
        $updatedData = [];
        foreach ($data['docs'] as $productData) {
            $updatedData[$productData["_id"]] = Product::elasticSearchtext($productData['_source']);
        }
        $query = new ElasticQuery;
        $query->setIndex($this->index);
        $query->initializeBulkIndexing();
        foreach ($updatedData as $productID => $elasticData) {
            $query->addToBulkIndexing($productID, $elasticData);
        });
        $responses = $query->bulk();
    }
}
