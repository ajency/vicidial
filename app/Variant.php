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

    function __construct(int $id){
    	$this->elastic_id = $id;
    	parent::__construct();
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

	//returns the availability using the inventory from the elasticData private variable
	public function getAvailability(){
		//@prasad, write logic decide if the variant is available 
		foreach ($$this->elastic_data["inventory"] as $inventory) {
			if($inventory["store_qty"] > 0 )
				return true;
		}
		return false;
	}

	public function getMessage(){
		return '20% OFF';
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
		return array (
	    'size' => 
	    array (
	      '18-24M' => 
	      array (
	        'id' => 123,
	        'availability' => true,
	      ),
	      '4-8Y' => 
	      array (
	        'id' => 125,
	        'availability' => true,
	      ),
	      '8-12Y' => 
	      array (
	        'id' => 126,
	        'availability' => true,
	      ),
	      '2-4Y' => 
	      array (
	        'id' => 124,
	        'availability' => false,
	      ),
	    ),
	);
	}

	public function getItemAttributes(){
		$item = array (
  			'availability' => $this->getAvailability(),
  			'message' => $this->getMessage(),
  			'attributes' => array (
    			'title' => 'Cotton Rich Super Skinny Fit Jeans',
    			'image_src_url' => $this->getPrimaryImageSrc(),
    			'image_srcset_url' => $this->getPrimaryImageSrcset(),
    			//write functions for the following variables too. this entire file is a pseudo code, so please check the laravel docs for the right way to name your getters for the models;
			    // 'size' => '1-2Y',
			    // 'price_mrp' => 1309,
			    // 'price_final' => 869,
		    ),
  			'related_items' => $this->getRelatedItems(),
  		);
		return $item;
	}
}
