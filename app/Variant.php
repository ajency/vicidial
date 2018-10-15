<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Elastic\ElasticQuery;

class Variant extends Model
{
	protected $elastic_data;
    /**
     *
     * @return 
     * @author 
     **/

    public function __construct(array $attributes = [])
    {
       parent::__construct($attributes);
    }

	public function newFromBuilder($attributes = [], $connection = null)
    {
    	
        $model = parent::newFromBuilder($attributes,$connection);
		$model->fetchElasticData();
        return $model;
    }


    /**
     * Set Elastic Data Array Directly
     *
     * @param array
     */
    public function set_elastic_data(array $elastic_data){
    	$this->elastic_data = $elastic_data;
    	$this->elastic_id = $elastic_data["id"];
    }

	private function fetchElasticData()
	{
		$q = new ElasticQuery();
		$variant_filter = $q->create_term("type", "variant");
		$variant_id = $q->create_term("id", $this->odoo_id);
		
		$q->set_index("products")
		->append_must($variant_filter)
		->append_must($variant_id)
		->set_size(1);
		$this->elastic_data = $q->search()["hits"]["hits"][0]["_source"];
	}

	/**
	* Returns true if atleast one of the wareshouses has inventory 
	*
	* @return bool
	*/
	public function getAvailability(){
		foreach ($this->elastic_data["inventory"] as $inventory) {
			if($inventory["store_qty"] > 0 )
				return true;
		}
		return false;
	}

	public function getMessage(){
		return '';
	}

	public function getPrimaryImageSrc(){
		return 'https://jeromie.github.io/kss/img/4front.jpg';
	}

	public function getPrimaryImageSrcset(){
		return array (
      				'100w' => 'https://jeromie.github.io/kss/img/4front.jpg',
      				'200w' => 'https://jeromie.github.io/kss/img/4front_2x.jpg',
      				'300w' => 'https://jeromie.github.io/kss/img/4front_3x.jpg',
     				'400w' => 'https://jeromie.github.io/kss/img/4front_4x.jpg',
    			);
	}

	public function getRelatedItems(){
		$q = new ElasticQuery();
		$variant_filter = $q->create_term("type", "variant");
		$color_filter = $q->create_term("var_color_id", $this->getVarColorId());
		$parent_id_filter = $q->create_term("parent_id", $this->getParentId());
		$notThisVariant = $q->create_term("id", $this->elastic_id);
		
		$q->set_index("products")
		->append_must($variant_filter)->append_must($color_filter)
		->append_must($parent_id_filter)->append_must_not($notThisVariant);
		$related_items = ["size" => []]; 
		$variants = $q->search()["hits"]["hits"];
		foreach ($variants as  $variant) {
			$item  = Varient::where('odoo_id', $variant["_source"]['id'])->first();
			$related_items["size"][$item->getSize()] = [
					"id" => $item->getID(),
					"availability" => $item->getAvailability(),
				
			];
		}
		return $related_items;
	}

	public function getItemAttributes(){
		$item = array (
  			'availability' => $this->getAvailability(),
  			'message' => $this->getMessage(),
  			'attributes' => array (
    			'title' => $this->getName(),
    			'image_src_url' => $this->getPrimaryImageSrc(),
    			'image_srcset_url' => $this->getPrimaryImageSrcset(),
				'size' => $this->getSize(),	
			    'price_mrp' => $this->getMRP(),
			    'price_final' => $this->getPriceFinal(),
		    ),
		    "id" => $this->getID(),
		    "quantity" => $this->getQuantity(),
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
    public function getMRP()
    {
        return $this->elastic_data["lst_price"];
    }

    /**
	* Get Variant Price Final
	*
	* @return double
	*/
    public function getPriceFinal()
    {
    	//unclear on what to return
        return $this->elastic_data["standard_price"];
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
    public function getQuantity(){
    	$total = 0;
    	foreach ($this->elastic_data["inventory"] as $inventory) {
			$total += $inventory["store_qty"];
		}
		return $total;

    }
}
