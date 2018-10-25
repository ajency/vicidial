<?php

namespace App;

use App\Elastic\ElasticQuery;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $elastic_data;
    protected $variant;
    protected $elastic_index = "";
    protected $fillable      = ['odoo_id', 'elastic_id', 'product_id', 'color_id'];
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
        if (isset($this->inventory["inventory"])) {
            foreach ($this->inventory["inventory"] as $inventory) {
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
        return array(
            '100w' => 'https://jeromie.github.io/kss/img/4front.jpg',
            '200w' => 'https://jeromie.github.io/kss/img/4front_2x.jpg',
            '300w' => 'https://jeromie.github.io/kss/img/4front_3x.jpg',
            '400w' => 'https://jeromie.github.io/kss/img/4front_4x.jpg',
        );
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

    public function getItem()
    {
        return array(
            'availability'  => $this->getAvailability(),
            'message'       => $this->getMessage(),
            'attributes'    => $this->getItemAttributes(),
            "id"            => $this->getID(),
            'related_items' => $this->getRelatedItems(),
        );

    }
    public function getItemAttributes()
    {

        return array(
            'title'            => $this->getName(),
            'image_src_url'    => $this->getPrimaryImageSrc(),
            'image_srcset_url' => $this->getPrimaryImageSrcset(),
            'size'             => $this->getSize(),
            'price_mrp'        => $this->getLstPrice(),
            'price_final'      => $this->getSalePrice(),
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
     * Get variant color id
     *
     * @return int
     */
    public function getVarColorId()
    {
        return $this->elastic_data["search_result_data"]["product_color_id"];
    }

    /**
     * Get Elastic variant Data
     *
     * @return string
     */
    public function getVariantData()
    {
        return $this->elastic_data;
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
        if (isset($this->inventory["inventory"])) {
            foreach ($this->inventory["inventory"] as $inventory) {
                $total += $inventory["quantity"];
            }
        }
        return $total;
    }

    public function getDiscount()
    {
        return $this->getLstPrice() - $this->getSalePrice();
    }
}
