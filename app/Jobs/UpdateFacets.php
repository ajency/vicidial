<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ajency\Connections\ElasticQuery;
use App\Facet;

class FetchProductImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $subject, $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject, $payload)
    {
        $this->subject = $subject;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $query      = [];
        $nested     = [];
        $path       = "search_data";
        $facet_type = "string_facet";

        foreach ($this->payload['facets'] as $facet) {
            $facet_data = Facet::find($facet['id']);
            $defaultFilters['primary_filter'][$facet_data['facet_name']][] = $facet_data['facet_value'];
            $facet_data->update([$facet['name'] => $facet['value']]);
        }
        $q = new ElasticQuery;
        $q->setIndex(config("elastic.indexes.product"));
        $filters = makeQueryfromParams($defaultFilters);
        foreach ($filters[$path][$facet_type] as $field => $value) {
            $facetName  = $q::createTerm($path . "." . $facet_type . '.facet_name', $field);
            $facetValue = $q::createTerms($path . "." . $facet_type . '.facet_value', $value['value']);
            $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
            $nested[]   = $q::createNested($path . '.' . $facet_type, $filter);
            $query      = $q::addToBoolQuery('should', $nested, $query);
        }
        $q->setQuery($query)->setSource(['search_result_data.product_slug'])->setSize(10000);
        $products = $q->search()['hits']['hits'];
        foreach ($products as $product) {
            RefreshProductCache($product['_source']['search_result_data']['product_slug']);
        }
    }
}
