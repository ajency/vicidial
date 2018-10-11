<?php
namespace App\Elastic;

use Elasticsearch\ClientBuilder;

class ElasticQuery {
	protected $params = ["index" => ""];

	public function set_index(string $index){
		$this->params ["index"] = $index;
		return $this;
	}
	public function set_body(){
		$this->params["body"] = [];
		return $this;
	}

	public function reset_bool(){
		if (isset($this->params['body'])){
			$this->params['body']["query"]['bool'] = [];
		}else{
			$this->set_body();
			$this->params['body']["query"]['bool'] = [];
		}
		return $this;
	}
	public function reset_must(){
		if (isset($this->params['body']["query"]['bool'])){
			$this->params['body']["query"]['bool']['must'] = [];
		}else{
			$this->reset_bool();
			$this->params['body']["query"]['bool']['must'] = [];
		}
		return $this;
	}

	public static function create_term($key,$value){
		return ["term"=>[$key=>$value]];
	}

	public function append_must($value){
		if (!isset($this->params['body']["query"]['bool']['must'])) $this->reset_must();
		$this->params['body']["query"]['bool']['must'][] = $value;
		return $this;
	}

	public function search(){
		$elastic_client = ClientBuilder::create()->build();
		return $elastic_client->search($this->params);
	}
	public function getParams(){
		
		return $this->params;
	}		
}


#$els = new ElasticQuery
#$product = ElasticQuery::create_term('product_id',$product_id);
#$els->append_must($product);