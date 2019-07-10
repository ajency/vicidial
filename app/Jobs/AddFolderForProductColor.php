<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddFolderForProductColor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $product_color;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product_color)
    {
        $this->product_color = $product_color;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $elastic_data = $this->product_color->getElasticData();
        $attributes = collect($elastic_data['search_data'][0]['attributes'])->keyBy('attribute_name');
        \Ajency\ServiceComm\Comm\Async::call('NewProductColor', [
            'catalog_id'          => 1,
            'external_product_id' => $this->product_color->product_id,
            'product_color_id'    => $this->product_color->id,
            'product_barcode'     => (isset($attributes['product_barcode']['attribute_value'])) ? $attributes['product_barcode']['attribute_value'] : '',
            'product_name'        => $elastic_data['search_result_data']['product_title'],
            'product_color'       => $elastic_data['search_result_data']['product_color_name'] . "-" . str_slug($elastic_data['search_result_data']['product_color_html']),
        ], 'sns', false);
    }
}
