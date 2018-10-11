<?php

namespace App\Elastic;

use Elasticsearch\ClientBuilder;

class ElasticQuery {
	protected $params = ["index" => ""];

	public function set_body(){
		$this->params["body"] = [];
		return true;
	}

	public function reset_bool(){
		if (isset($this->params['body'])){
			$this->params['body']['bool'] = []
		}else{
			$this->reset_body();
			$this->params['body']['bool'] = []
		}
		return true;
	}
	public function reset_must_empty(){
		if (isset($this->params['body']['bool'])){
			$this->params['body']['bool']['must'] = []
		}else{
			$this-reset_bool();
			$this->params['body']['bool']['must'] = []
		}
		return true;
	}		
}