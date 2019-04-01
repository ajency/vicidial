<?php

namespace App;

use Ajency\Connections\ElasticQuery;
use Ajency\Connections\OdooConnect;
use Ajency\ServiceComm\Comm\Sync;
use App\Facet;
use App\Jobs\UpdateVariantInventory;
use App\Location;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use SoapBox\Formatter\Formatter;

class Variant extends Model
{

    protected $elastic_data;
    protected $elastic_id;
    protected $variant;
    protected $elastic_index = "";
    protected $fillable      = ['odoo_id', 'product_color_id'];
    protected $casts         = [
        'inventory' => 'array',
        'active'    => 'boolean',
        'deleted'   => 'boolean',
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

    public function getInventoryAttribute()
    {
        return Sync::call('inventory', 'getVariantInventory', ['variant' => $this->id]);
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = parent::newFromBuilder($attributes, $connection);
        $arr   = (array) $attributes;
        if (isset($arr['product_color_id'])) {
            $model->fetchElasticData();
        }
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
        $activeLocations = Location::where('use_in_inventory', true)->pluck('id')->toArray();
        $invData         = $this->inventory;
        foreach ($invData as $inventory) {
            if ($inventory["quantity"] > 0 && in_array($inventory['location_id'], $activeLocations)) {
                return true;
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
            'product_slug'       => $this->getProductSlug(),
            'availability'       => $this->getAvailability(),
            'message'            => $this->getMessage(),
            'attributes'         => $this->getItemAttributes(),
            "id"                 => $this->id,
            "pixel_id"           => $this->getParentId() . "-" . $this->getVarColorId(),
        );

        if ($related_items) {
            $item['related_items'] = $this->getRelatedItems();
        }

        if ($current_quantity) {
            $item['storewise_quantity'] = $this->getQuantityStoreWise();
        }

        return $item;
    }
    
    public function getItemAttributes()
    {

        return array(
            'title'        => $this->getTitle(),
            'images'       => $this->getPrimaryImageSrcset(),
            'size'         => $this->getSize(),
            'price_mrp'    => $this->getLstPrice(),
            'price_final'  => $this->getSalePrice(),
            'discount_per' => calculateDiscount($this->getLstPrice(), $this->getSalePrice()),
        );
    }

    /**
     * Get Variant Size.
     *
     * @return string
     */
    public function getSize()
    {
        $facet = Facet::where('facet_value', $this->variant["variant_size_name"])->first();
        return (isset($facet['display_name'])) ? $facet['display_name'] : $this->variant["variant_size_name"];
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
    public function getDiscount()
    {
        return $this->variant["variant_list_price"] - $this->variant["variant_sale_price"];
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
    public function getVariantData($mode, $prefix = '', $data = [])
    {
        $productData = $this->elastic_data["search_result_data"];
        $variantData = collect($this->elastic_data['variants'])->where('variant_id', $this->odoo_id)->first();
        $data        = array_merge($productData, $variantData);
        if ($mode == 'all') {
            $filteredData = [];
            foreach ($data as $key => $value) {
                $filteredData[$prefix . $key] = $value;
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
     * Get variant brand
     *
     * @return string
     */

    public function getBrand()
    {
        return (isset($this->elastic_data["search_result_data"]["product_brand"]) && $this->elastic_data["search_result_data"]["product_brand"]) ? $this->elastic_data["search_result_data"]["product_brand"] : false;
    }

    /**
     * Get variant subtype
     *
     * @return string
     */

    public function getCategoryType()
    {
        return (isset($this->elastic_data["search_result_data"]["product_category_type"]) && $this->elastic_data["search_result_data"]["product_category_type"]) ? $this->elastic_data["search_result_data"]["product_category_type"] : false;
    }

    /**
     * Get display title
     *
     * @return string
     */

    public function getTitle()
    {
        return ($this->getBrand()) ? $this->getBrand() . ' - ' . $this->getName() : $this->getName();
    }

    /**
     * Get Variant Total Quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        $total           = 0;
        $activeLocations = Location::where('use_in_inventory', true)->pluck('id')->toArray();
        if (isset($this->inventory)) {
            foreach ($this->inventory as $inventory) {
                if ($inventory["quantity"] > 0 && in_array($inventory['location_id'], $activeLocations) == true) {
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
        $quantity_arr    = array();
        $location_arr    = array();
        $activeLocations = Location::where('use_in_inventory', true)->pluck('id')->toArray();
        if (isset($this->inventory)) {
            foreach ($this->inventory as $inventory) {
                if ($inventory["quantity"] > 0 && in_array($inventory['location_id'], $activeLocations)) {
                    $location       = Location::where('id', $inventory["location_id"])->first();
                    $quantity_arr[] = array('warehouse' => $location->warehouse->name, 'location' => $location->name, 'quantity' => $inventory["quantity"]);
                }
            }
        }
        return $quantity_arr;
    }

    public function getProductSlug()
    {
        return $this->elastic_data["search_result_data"]["product_slug"];
    }

    public static function getVariantProductIdFromOdoo($variant_id)
    {
        $odoo = new Elastic\OdooConnect;
        return $odoo->defaultExec('product.product', 'read', [[$variant_id]], ['fields' => ['product_tmpl_id']])->first()['product_tmpl_id'][0];
    }

    // public static function addUpdateInventoryJobs()
    // {
    //     $variants = self::select('odoo_id')->get()->pluck('odoo_id')->toarray();
    //     $job_sets = array_chunk($variants, config('odoo.update_inventory'));
    //     foreach ($job_sets as $job_set) {
    //         UpdateVariantInventory::dispatch($job_set)->onQueue('update_inventory');
    //     }
    // }

    public static function updateInventory($params)
    {
        UpdateVariantInventory::dispatch($params['variants'])->onQueue('update_inventory');
    }



    public static function getWarehouseInventory()
    {
        $availableVariants = self::select(["odoo_id", "inventory"])->where('inventory', 'not like', '[]')->get();
        $locations         = Location::where('use_in_inventory', true)->get()->pluck('display_name', 'odoo_id');
        $header            = ['variant_odoo_id'];
        foreach ($locations as $loc_id => $loc_name) {
            $header[] = $loc_name . " (" . $loc_id . ")";
        }
        $variantInventory = collect([$header]);
        foreach ($availableVariants as $variant) {
            $inventoryLine = [$variant->odoo_id];
            foreach ($locations as $loc_id => $loc_name) {
                $inventoryLine[] = (isset($variant->inventory["$loc_id"])) ? $variant->inventory["$loc_id"]['quantity'] : 0;
            }
            \Log::debug(collect($inventoryLine));
            $variantInventory->push($inventoryLine);
        }
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertAll($variantInventory->toArray());
        $csv->output('inventory.csv');
    }

    public static function updateVariantDiffFile()
    {
        $dbVariants = self::select('odoo_id')->where('active', 1)->where('deleted', 0)->get()->pluck('odoo_id');
        $diff       = getOdooDiff('product.product', $dbVariants);
        $formatter  = Formatter::make($diff, Formatter::ARR);
        $diffJson   = $formatter->toJson();
        $now        = Carbon::now();
        Storage::disk('s3')->put(config('ajfileupload.doc_base_root_path') . '/VariantOdooDbDiff' . $now->timestamp . '.json', $diffJson, 'public');
        return redirect(Storage::disk('s3')->url(config('ajfileupload.doc_base_root_path') . '/VariantOdooDbDiff' . $now->timestamp . '.json'));
    }
}
