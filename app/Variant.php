<?php

namespace App;

use App\Elastic\ElasticQuery;
use Illuminate\Database\Eloquent\Model;
use App\Location;

class Variant extends Model
{

    protected $elastic_data;
    protected $elastic_id;
    protected $variant;
    protected $elastic_index = "";
    protected $fillable      = ['odoo_id', 'product_color_id'];
    protected $casts         = [
        'inventory' => 'array',
    ];
    /**
     *
     * @return
     * @author
     **/

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->elastic_index = config('elastic.indexes.product');
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {

        $model = parent::newFromBuilder($attributes, $connection);
        if(isset($this->productColor))
            $model->fetchElasticData();
        return $model;
    }

    public function productColor()
    {
        return $this->belongsTo('App\ProductColor', 'product_color_id', "id");
    }
    /**
     * Set Elastic Data Array Directly
     *
     * @param array
     */
    public function setElasticData(array $elastic_data)
    {
        $this->elastic_data = $elastic_data;
        $this->elastic_id   = $elastic_data["id"];
    }

    private function fetchElasticData()
    {
        $this->elastic_id = $this->productColor->elastic_id;
        $q                = new ElasticQuery();
        $q->setIndex($this->elastic_index);
        $search = $q->get($this->elastic_id);
        \Log::info("elastic object fetched");
        \Log::info($search);
        $this->elastic_data = $search["_source"];
        foreach ($this->elastic_data["variants"] as $variant) {
            if ($variant["variant_id"] == $this->odoo_id) {
                $this->variant = $variant;
                break;
            }

        }
    }

    /**
     * Returns true if atleast one of the wareshouses has inventory
     *
     * @return bool
     */
    public function getAvailability()
    {
        if (isset($this->inventory)) {
            foreach ($this->inventory as $inventory) {
                if ($inventory["quantity"] > 0) {
                    return true;
                }

            }
        }

        return false;
    }

    public function getVariantSequence()
    {
        $data = $this->elastic_data["search_result_data"]["variants"];
        foreach ($data as $key => $value) {
            if ($value["variant_id"] == $this->odoo_id) {
                return $key;
            }
        }
    }

    public function getMessage()
    {
        return '';
    }

    public function getPrimaryImageSrc()
    {
        return 'https://jeromie.github.io/kss/img/4front.jpg';
    }

    public function getPrimaryImageSrcset()
    {
        $default_imgs = $this->productColor->getDefaultImage(["variant-thumb"]);
        if (isset($default_imgs["variant-thumb"])) {
            return $default_imgs["variant-thumb"];
        } else {
            return $default_imgs;
        }

    }

    public function getRelatedItems()
    {
        $related_items = ["size" => []];
        $variants      = $this->elastic_data["variants"];
        foreach ($variants as $variant) {
            if ($variant["variant_id"] != $this->odoo_id) {
                $related_items["size"][] = [
                    "id"           => $variant["variant_id"],
                    "availability" => $variant["variant_availability"],
                    "value"        => $variant["variant_size_name"],

                ];
            }

        }
        return $related_items;
    }

    public function getItem($related_items = true, $current_quantity = false)
    {
        $item = array(
            'product_slug' => $this->getProductSlug(),
            'availability' => $this->getAvailability(),
            'message'      => $this->getMessage(),
            'attributes'   => $this->getItemAttributes(),
            "id"           => $this->id,
        );

        if ($related_items) {
            $item['related_items'] = $this->getRelatedItems();
        }

        if ($current_quantity) {
            $item['available_quantity'] = $this->getQuantityStoreWise();
        }

        return $item;

    }
    public function getItemAttributes()
    {

        return array(
            'title'       => $this->getName(),
            'images'      => $this->getPrimaryImageSrcset(),
            'size'        => $this->getSize(),
            'price_mrp'   => $this->getLstPrice(),
            'price_final' => $this->getSalePrice(),
        );
    }

    /**
     * Get Variant Size.
     *
     * @return string
     */
    public function getSize()
    {
        return $this->variant["variant_size_name"];
    }

    /**
     * Get Variant MRP
     *
     * @return double
     */
    public function getLstPrice()
    {
        return $this->variant["variant_list_price"];
    }

    /**
     * Get Variant Price Final
     *
     * @return double
     */
    public function getSalePrice()
    {
        return $this->variant["variant_sale_price"];
    }

    /**
     * Get Variant Savings
     *
     * @return double
     */
    public function getSavings()
    {
        return $this->variant["variant_sale_price"] - $this->variant["variant_list_price"];
    }

    /**
     * Get variant color id
     *
     * @return int
     */
    public function getVarColorId()
    {
        return $this->elastic_data["search_result_data"]["product_color_id"];
    }

    /**
     * Get Elastic ProductColor Data
     *
     * @return string
     */
    public function getParentElasticData()
    {
        return $this->elastic_data;
    }

    /**
     * Get Elastic variant Data
     *
     * @return string
     */
    public function getVariantData($mode,$prefix = '', $data = [])
    {
        $productData = $this->elastic_data["search_result_data"];
        $variantData = collect($this->elastic_data['variants'])->where('variant_id', $this->odoo_id)->first();
        $data        = array_merge($productData, $variantData);
        if ($mode == 'all') {
            $filteredData = [];
            foreach ($data as $key => $value) {
               $filteredData[$prefix.$key] = $value;
            }
            return $filteredData;
        } elseif ($mode == 'only') {
            $filteredData = [];
            foreach ($data as $key) {
                $filteredData[$key] = $data[$key];
            }
            return $filteredData;
        }
    }

    /**
     * Get Elastic variant ID
     *
     * @return int
     */
    public function getID()
    {
        return $this->variant["variant_id"];
    }

    /**
     * Get Elastic variant Data
     *
     * @return int
     */

    public function getParentId()
    {

        return $this->elastic_data["search_result_data"]["product_id"];
    }

    /**
     * Get variant name
     *
     * @return string
     */

    public function getName()
    {
        return $this->elastic_data["search_result_data"]["product_title"];
    }

    /**
     * Get Variant Total Quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        $total = 0;
        if (isset($this->inventory)) {
            foreach ($this->inventory as $inventory) {
                if ($inventory["quantity"] >= 0) {
                    $total += $inventory["quantity"];
                }
            }
        }
        return $total;
    }

    /**
     * Get Variant Quantity StoreWise
     *
     * @return int
     */
    public function getQuantityStoreWise()
    {
        $quantity_arr = array();
        $location_arr = array();
        if (isset($this->inventory)) {
            foreach ($this->inventory as $inventory) {
                if ($inventory["quantity"] > 0) {
                    $location = Location::where('odoo_id', $inventory["location_id"])->first();
                    $quantity_arr[] = array('warehouse' => $location->warehouse->name, 'location' => $location->name, 'quantity' => $inventory["quantity"]);
                }
            }
        }
        return $quantity_arr;
    }

    public function getDiscount()
    {
        return $this->getLstPrice() - $this->getSalePrice();
    }

    public function getProductSlug()
    {
        return $this->elastic_data["search_result_data"]["product_slug"];
    }

    public static function getVariantProductIdFromOdoo($variant_id){
        $odoo = new Elastic\OdooConnect;
        return $odoo->defaultExec('product.product','read',[[$variant_id]],['fields'=>['product_tmpl_id']])->first()['product_tmpl_id'][0];
    }

    public static function addUpdateInventoryJobs()
    {
        $variants = Variant::select('odoo_id')->get()->pluck('odoo_id')->toarray();
        $job_sets = array_chunk($variants,config('odoo.limit'));
        foreach ($job_sets as $job_set) {
            UpdateVariantInventory::dispatch($job_set)->onQueue('update_inventory');
        }
    }
}
