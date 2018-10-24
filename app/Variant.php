<?php

namespace App;

use App\Elastic\ElasticQuery;
use Illuminate\Database\Eloquent\Model;

use Ajency\FileUpload\FileUpload;

class Variant extends Model
{
    use FileUpload;

    protected $elastic_data;
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
        $q              = new ElasticQuery();
        $variant_filter = $q->createTerm("type", "variant");
        $variant_id     = $q->createTerm("id", $this->odoo_id);

        $q->setIndex($this->elastic_index)
            ->appendMust($variant_filter)
            ->appendMust($variant_id)
            ->setSize(1);
        $search = $q->search();
        \Log::info("elastic object fetched");
        \Log::info($search);
        $this->elastic_data = $search["hits"]["hits"][0]["_source"];
    }

    /**
     * Returns true if atleast one of the wareshouses has inventory
     *
     * @return bool
     */
    public function getAvailability()
    {
        foreach ($this->elastic_data["inventory"] as $inventory) {
            if ($inventory["store_qty"] > 0) {
                return true;
            }

        }
        return false;
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
        $q                = new ElasticQuery();
        $variant_filter   = $q->createTerm("type", "variant");
        $color_filter     = $q->createTerm("var_color_id", $this->getVarColorId());
        $parent_id_filter = $q->createTerm("parent_id", $this->getParentId());
        $notThisVariant   = $q->createTerm("id", $this->elastic_id);

        $q->setIndex($this->elastic_index)
            ->appendMust($variant_filter)->appendMust($color_filter)
            ->appendMust($parent_id_filter)->appendMustNot($notThisVariant);
        $related_items = ["size" => []];
        $variants      = $q->search()["hits"]["hits"];
        foreach ($variants as $variant) {
            $item                    = Variant::where('odoo_id', $variant["_source"]['id'])->first();
            $related_items["size"][] = [
                "id"           => $item->getID(),
                "availability" => $item->getAvailability(),
                "value"        => $item->getSize(),

            ];
        }
        return $related_items;
    }

    public function getItemAttributes()
    {
        $item = array(
            'availability'  => $this->getAvailability(),
            'message'       => $this->getMessage(),
            'attributes'    => array(
                'title'            => $this->getName(),
                'image_src_url'    => $this->getPrimaryImageSrc(),
                'image_srcset_url' => $this->getPrimaryImageSrcset(),
                'size'             => $this->getSize(),
                'price_mrp'        => $this->getLstPrice(),
                'price_final'      => $this->getSalePrice(),
            ),
            "id"            => $this->getID(),
            "quantity"      => $this->getQuantity(),
            'related_items' => $this->getRelatedItems(),
        );
        return $item;
    }

    /**
     * Get Variant Size.
     *
     * @return string
     */
    public function getSize()
    {
        return $this->elastic_data["var_size_value"];
    }

    /**
     * Get Variant MRP
     *
     * @return double
     */
    public function getLstPrice()
    {
        return $this->elastic_data["lst_price"];
    }

    /**
     * Get Variant Price Final
     *
     * @return double
     */
    public function getSalePrice()
    {
        //unclear on what to return
        return $this->elastic_data["sale_price"];
    }

    /**
     * Get variant color id
     *
     * @return int
     */
    public function getVarColorId()
    {
        return $this->elastic_data["var_color_id"];
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
     * Get Elastic variant Data
     *
     * @return int
     */
    public function getID()
    {

        return $this->elastic_data["id"];
    }

    /**
     * Get Elastic variant Data
     *
     * @return int
     */

    public function getParentId()
    {

        return $this->elastic_data["parent_id"];
    }

    /**
     * Get variant name
     *
     * @return string
     */

    public function getName()
    {
        return $this->elastic_data["name"];
    }

    /**
     * Get Variant Total Quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        $total = 0;
        foreach ($this->elastic_data["inventory"] as $inventory) {
            $total += $inventory["store_qty"];
        }
        return $total;

    }
}
