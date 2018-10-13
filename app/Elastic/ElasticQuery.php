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

	/**
	* Set the index in a ElasticQuery
	*
	* @param string $index Index name
	* @return Varient
	*/
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

	/**
	* Appends filter, conditions to query.bool.must
	*
	* @param string $condition
	* @return Varient
	*/
	public function append_must($condition){
		if (!isset($this->params['body']["query"]['bool']['must']))
			$this->reset_must();
		$this->params['body']["query"]['bool']['must'][] = $condition;
		return $this;
	}

	public function reset_must_not(){
		if (!isset($this->params['body']["query"]['bool'])){
			$this->reset_bool();
		}
		$this->params['body']["query"]['bool']['must_not'] = [];
		return $this;
	}

	/**
	* Appends filter, conditions to query.bool.must_not
	*
	* @param string $condition
	* @return Varient
	*/
	public function append_must_not($condition){
		if (!isset($this->params['body']["query"]['bool']['must_not']))
			$this->reset_must_not();
		$this->params['body']["query"]['bool']['must_not'][] = $condition;
		return $this;
	}

	public static function create_term($field, $value){
		return ["term" => [$field => $value]];
	}

	public static function create_match($field, $value){
		return ["match" => [$field => $value]];
	}

	public static function create_range($field,array $options){
		return ["range" => [$field => $options]];
	}

	public function set_size(int $size){
		if (!isset($this->params['body']))
			$this->set_query();
		$this->params["body"]["size"] = $size;
		return $this;
	}

	/**
	* Sets whats fields from a document to fetch
	* Useful only when doing search operation
	*
	* @param array $fields
	* @return Varient
	*/
	public function set_source(array $fields){
		if (!isset($this->params['body']))
			$this->set_body();
		$this->params["body"]["source"] = $fields;
		return $this;
	}

	/**
	* Sets the offset from where to start fetching search  
	*
	* @param int $from offset
	* @return Varient
	*/
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

	/**
	* Elastic Search function
	* Can be use for Search and Aggregations
	*
	* @param array $params Search params
	* @return array Elasticsearch Response
	*/
	public function search(){
		return $this->elastic_client->search($this->params);
	}

	public function get($id){
		$this->params["type"] = "_doc";
		$this->params["id"] = $id;
		return $this->elastic_client->get($this->params);
	}

	/**
	* Elastic Update function
	* Can be use for Updating specific fields in documents
	*
	* @return array Elasticsearch Response
	*/
	public function update(){
		return $this->elastic_client->update($this->params);
	}

	/**
	* Elastic Index function
	* Used for indexing documents one at a time
	*
	* @return array Elasticsearch Response
	*/
	public function index(){
		return $this->elastic_client->index($this->params);
	}

	/**
	* Elastic Bulk Index function
	* Used for indexing documents documents in bulk
	* use initialize_bulk_indexing first 
	* use add_to_bulk_index to add documents for indexing
	* @return array Elasticsearch Response
	*/
	public function bulk(){
		return $this->elastic_client->bulk($this->params);
	}


	/**
	* Returns the $params array for debugging
	* or manually passing params to Elastic Library
	* 
	* @return array $this->params
	*/
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

	public function initialize_bulk_indexing(string $index, array $options =[]){
		$this->index = $index;
		$this->options = $options;
		$this->params = ['body' => []];
		return $this;
	}

	public function add_to_bulk_indexing(string $id, array $data, $options=[]){
		
		$meta = [
			'index' => $options + [
	            '_index' => $this->index,
	            '_type' => '_doc',
	            '_id' => $id,
	        ] + $this->options
	    ];
		$this->params["body"][] = $meta;
		$this->params["body"][] = $data;

		return $this;
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

	public static function create_agg_max(string $name, string $field){
		return [ $name => [ "max" => ["field" => $field]]];
	}

	public static function create_agg_min(string $name, string $field){
		return [ $name => [ "min" => ["field" => $field]]];	
	}

	public static function create_agg_sum(string $name, string $field){
		return [ $name => [ "sum" => ["field" => $field]]];
	}

	public static function create_agg_terms(string $name, string $field){
		return [ $name => [ "terms" => ["field" => $field]]];
	}

	public static function create_agg_nested(string $name, string $path){
		return [ $name => [ "nested" => ["path" => $path]]];
	}

	public static function add_to_aggregation(array $aggs, array $new_aggs){
		
		$aggs[current(array_keys($aggs))]["aggs"] = $new_aggs;
		return $aggs;
	}

	public static function add_metric(array $aggs, array $metric){
		return $aggs + $metric;
	}

	// public static function add_metric(array $aggs, array $metric){
	// 	return $aggs + $metric;
	// }

	public function init_aggregation(){
		if(!isset($this->params["body"])){
			$this->set_body();
		};
		$this->params["body"]["aggs"] = [];
		return $this;
	}

	public function set_aggregation(array $aggs){
		// $this->set_body();
		// $this->params["body"]["query"] =["match_all" => new \stdClass()];
		$this->params["body"]["aggs"] = $aggs;
		return $this;
	}
}
