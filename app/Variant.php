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

    function __construct(int $id=0){
    	if($id){
    		$this->set_elastic_id($id);
    	}
    	parent::__construct();
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

	/**
	* Set elastic id and fetch variant 
	*
	* @param int
	*/
    private function set_elastic_id(int $id){
    	$this->elastic_id = $id;
    	$this->getElasticData();
    }

	private function getElasticData()
	{
		//use $this->elastic_id to get all the data for this varient from elastic search.
		//we might use this function as a constructor. This function gets all the data from elastic and saves it in $elastic_data private variable of the class
		//this includes all the data along with its inventory
		//@prasad, 
		$q = new ElasticQuery();
		$variant_filter = $q->create_term("type", "variant");
		$variant_id = $q->create_term("id", $this->elastic_id);
		
		$q->set_index("products")
		->append_must($variant_filter)
		->append_must($variant_id)
		->set_size(1);
		$this->elastic_data = $q->search()["hits"]["hits"][0]["_source"];
		// // print_r($q->getParams());
		// print_r($this->elastic_data);
		
	}

	/**
	* Returns true if atleast one of the wareshouses has inventory 
	*
	* @return bool
	*/
	//returns the availability using the inventory from the elasticData private variable
	public function getAvailability(){
		//@prasad, write logic decide if the variant is available 
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
			$item  = new Varient();
			$item->set_elastic_data($variant["_source"]);
			$related_items["size"][$item->getSize()] = [
					"id" => $item->getID(),
					"availability" => $item->getAvailability(),
				
			];
		}
		return $related_items;
	// 	return array (
	//     'size' => 
	//     array (
	//       '18-24M' => 
	//       array (
	//         'id' => 123,
	//         'availability' => true,
	//       ),
	//       '4-8Y' => 
	//       array (
	//         'id' => 125,
	//         'availability' => true,
	//       ),
	//       '8-12Y' => 
	//       array (
	//         'id' => 126,
	//         'availability' => true,
	//       ),
	//       '2-4Y' => 
	//       array (
	//         'id' => 124,
	//         'availability' => false,
	//       ),
	//     ),
	// );
	}

	public function getItemAttributes(){
		$item = array (
  			'availability' => $this->getAvailability(),
  			'message' => $this->getMessage(),
  			'attributes' => array (
    			'title' => $this->getName(),
    			'image_src_url' => $this->getPrimaryImageSrc(),
    			'image_srcset_url' => $this->getPrimaryImageSrcset(),
    			//write functions for the following variables too. this entire file is a pseudo code, so please check the laravel docs for the right way to name your getters for the models;
			    // 'size' => '1-2Y',
			    // 'price_mrp' => 1309,
			    // 'price_final' => 869,
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
