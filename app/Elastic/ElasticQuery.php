<?php
namespace App\Elastic;

use Elasticsearch\ClientBuilder;

class ElasticQuery {
	protected $params = ["index" => ""];

	public function __construct()
    {
        $this->elastic_client = ClientBuilder::create()->build();
    }

	public function set_index(string $index){
		$this->params ["index"] = $index;
		return $this;
	}

	public function set_body(){
		$this->params["body"] = [];
		return $this;
	}

	public function set_query(){
		if (!isset($this->params['body'])){
			$this->set_body();
		}
		$this->params['body']["query"] = [];
		return $this;
	}

	public function reset_bool(){
		if (!isset($this->params['body']["query"])){
			$this->set_query();
		}
		$this->params['body']["query"]['bool'] = [];
		return $this;
	}

	public function reset_must(){
		if (!isset($this->params['body']["query"]['bool'])){
			$this->reset_bool();
		}
		$this->params['body']["query"]['bool']['must'] = [];
		return $this;
	}

	public function append_must($value){
		if (!isset($this->params['body']["query"]['bool']['must']))
			$this->reset_must();
		$this->params['body']["query"]['bool']['must'][] = $value;
		return $this;
	}

	public static function create_term($key,$value){
		return ["term"=>[$key=>$value]];
	}

	public static function create_match($key,$value){
		return ["match"=>[$key=>$value]];
	}

	public function search(){
		return $this->elastic_client->search($this->params);
	}

	public function getParams(){
		
		return $this->params;
	}		
}
