<?php
namespace App\Elastic;

use Elasticsearch\ClientBuilder;

class ElasticQuery {
	protected $params = ["index" => ""];

	public function __construct()
    {
        $this->elastic_client = ClientBuilder::create()->build();
    }

    public function reset(){
		$this->params = [];
		return $this;
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

	public function reset_must_not(){
		if (!isset($this->params['body']["query"]['bool'])){
			$this->reset_bool();
		}
		$this->params['body']["query"]['bool']['must_not'] = [];
		return $this;
	}

	public function append_must_not($value){
		if (!isset($this->params['body']["query"]['bool']['must_not']))
			$this->reset_must_not();
		$this->params['body']["query"]['bool']['must_not'][] = $value;
		return $this;
	}

	public static function create_term($field, $value){
		return ["term" => [$field => $value]];
	}

	public static function create_match($field, $value){
		return ["match" => [$field => $value]];
	}

	public static function create_range($field, $value){
		return ["match" => [$field => $value]];
	}

	public function set_size(int $size){
		if (!isset($this->params['body']))
			$this->set_query();
		$this->params["body"]["size"] = $size;
		return $this;
	}

	public function set_from(int $from){
		if (!isset($this->params['body']))
			$this->set_query();
		$this->params["body"]["from"] = $from;
		return $this;
	}

	public function set_scroll(string $scroll, int $size){
		if (!isset($this->params['body']))
			$this->set_query();
		$this->params["scroll"] = $scroll;
		$this->params["size"] = $size;
		return $this;
	}

	public function search(){
		return $this->elastic_client->search($this->params);
	}

	public function get($id){
		$this->params["type"] = "_doc";
		$this->params["id"] = $id;
		return $this->elastic_client->get($this->params);
	}

	public function update(){
		return $this->elastic_client->update($this->params);
	}

	public function index(){
		return $this->elastic_client->index($this->params);
	}


	public function getParams(){
		return $this->params;
	}

	public function create_get_params(string $id){
		// $this->params = [];
		$this->params["type"] = "_doc";
		$this->params["id"] = $id;
		return $this;

	}
	public function create_update_params(string $id, array $body, array $params=[]){
		$this->params["type"] = "_doc";
		$this->params["id"] = $id;
		$this->params["body"]["doc"] = $body;
		$this->params = $params + $this->params;
		return $this;
	}

	public function create_index_params(string $id, array $body, array $params=[]){
		$this->params["type"] = "_doc";
		$this->params["body"] = $body;
		$this->params["id"] = $id;
		$this->params = $params + $this->params;
		return $this;
	}

	public function create_scroll_params(string $scroll, $scroll_id){
		$this->params = []; //  only 2 params
		$this->params["scroll"] = $scroll;
		$this->params["scroll_id"] = $scroll_id;
		return $this;
	}

	public function create_bulk_params(){
		
	}

	public function create_create_index_params(string $index, array $mappings=[]){
		$this->params = [
            'index' => $index,
            "body" => [
            	"mappings" => [
            		"_doc" => [
            			"properties" => $mappings
            		]
            	]
            ]
        ];
		return $this->elastic_client->indices()->create($this->params);
	}

	public function create_delete_index_params(string $index){
		$this->params = ["index" => $index];
		return $this->elastic_client->indices()->delete($this->params);
	}
		
}
