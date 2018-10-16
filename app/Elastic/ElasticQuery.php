<?php
namespace App\Elastic;

use Elasticsearch\ClientBuilder;

class ElasticQuery
{
    protected $params = ["index" => ""];

    public function __construct()
    {
        $hosts = [
            [
                "host"   => config('elastic.host'),
                "port"   => config('elastic.port'),
                "scheme" => config('elastic.scheme'),
                "user"   => config('elastic.user'),
                "pass"   => config('elastic.pass'),

            ],
        ];
        \Log::debug(json_encode($hosts, true));
        $this->elastic_client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
        // $this->elastic_client = ClientBuilder::create()->build();
    }

    public function reset()
    {
        $this->params = [];
        return $this;
    }

    /**
     * Set the index in a ElasticQuery
     *
     * @param string $index Index name
     * @return ElasticQuery
     */
    public function setIndex(string $index)
    {
        $this->params["index"] = $index;
        return $this;
    }

    public function setBody()
    {
        $this->params["body"] = [];
        return $this;
    }

    public function setQuery()
    {
        if (!isset($this->params['body'])) {
            $this->setBody();
        }
        $this->params['body']["query"] = [];
        return $this;
    }

    public function resetBool()
    {
        if (!isset($this->params['body']["query"])) {
            $this->setQuery();
        }
        $this->params['body']["query"]['bool'] = [];
        return $this;
    }

    public function resetMust()
    {
        if (!isset($this->params['body']["query"]['bool'])) {
            $this->resetBool();
        }
        $this->params['body']["query"]['bool']['must'] = [];
        return $this;
    }

    /**
     * Appends filter, conditions to query.bool.must
     *
     * @param string $condition
     * @return ElasticQuery
     */
    public function appendMust($condition)
    {
        if (!isset($this->params['body']["query"]['bool']['must'])) {
            $this->resetMust();
        }

        $this->params['body']["query"]['bool']['must'][] = $condition;
        return $this;
    }

    public function resetMustNot()
    {
        if (!isset($this->params['body']["query"]['bool'])) {
            $this->resetBool();
        }
        $this->params['body']["query"]['bool']['must_not'] = [];
        return $this;
    }

    /**
     * Appends filter, conditions to query.bool.must_not
     *
     * @param string $condition
     * @return ElasticQuery
     */
    public function appendMustNot($condition)
    {
        if (!isset($this->params['body']["query"]['bool']['must_not'])) {
            $this->resetMustNot();
        }

        $this->params['body']["query"]['bool']['must_not'][] = $condition;
        return $this;
    }

    public static function createTerm($field, $value)
    {
        return ["term" => [$field => $value]];
    }

    public static function createMatch($field, $value)
    {
        return ["match" => [$field => $value]];
    }

    public static function createRange($field, array $options)
    {
        return ["range" => [$field => $options]];
    }

    public function setSize(int $size)
    {
        if (!isset($this->params['body'])) {
            $this->setQuery();
        }

        $this->params["body"]["size"] = $size;
        return $this;
    }

    /**
     * Sets whats fields from a document to fetch
     * Useful only when doing search operation
     *
     * @param array $fields
     * @return ElasticQuery
     */
    public function setSource(array $fields)
    {
        if (!isset($this->params['body'])) {
            $this->setBody();
        }

        $this->params["body"]["source"] = $fields;
        return $this;
    }

    /**
     * Sets the offset from where to start fetching search
     *
     * @param int $from offset
     * @return ElasticQuery
     */
    public function setFrom(int $from)
    {
        if (!isset($this->params['body'])) {
            $this->setQuery();
        }

        $this->params["body"]["from"] = $from;
        return $this;
    }

    public function setScroll(string $scroll, int $size)
    {
        if (!isset($this->params['body'])) {
            $this->setQuery();
        }

        $this->params["scroll"] = $scroll;
        $this->params["size"]   = $size;
        return $this;
    }

    /**
     * Elastic Search function
     * Can be use for Search and Aggregations
     *
     * @param array $params Search params
     * @return array Elasticsearch Response
     */
    public function search()
    {
        return $this->elastic_client->search($this->params);
    }

    public function get($id)
    {
        $this->params["type"] = "_doc";
        $this->params["id"]   = $id;
        return $this->elastic_client->get($this->params);
    }

    /**
     * Elastic Update function
     * Can be use for Updating specific fields in documents
     *
     * @return array Elasticsearch Response
     */
    public function update()
    {
        return $this->elastic_client->update($this->params);
    }

    /**
     * Elastic Index function
     * Used for indexing documents one at a time
     *
     * @return array Elasticsearch Response
     */
    public function index()
    {
        return $this->elastic_client->index($this->params);
    }

    /**
     * Elastic Bulk Index function
     * Used for indexing documents documents in bulk
     * use initializeBulkIndexing first
     * use add_to_bulk_index to add documents for indexing
     * @return array Elasticsearch Response
     */
    public function bulk()
    {
        return $this->elastic_client->bulk($this->params);
    }

    /**
     * Returns the $params array for debugging
     * or manually passing params to Elastic Library
     *
     * @return array $this->params
     */
    public function getParams()
    {
        return $this->params;
    }

    public function createGetParams(string $id)
    {
        // $this->params = [];
        $this->params["type"] = "_doc";
        $this->params["id"]   = $id;
        return $this;

    }

    public function createUpdateParams(string $id, array $body, array $params = [])
    {
        $this->params["type"]        = "_doc";
        $this->params["id"]          = $id;
        $this->params["body"]["doc"] = $body;
        $this->params                = $params + $this->params;
        return $this;
    }

    public function createIndexParams(string $id, array $body, array $params = [])
    {
        $this->params["type"] = "_doc";
        $this->params["body"] = $body;
        $this->params["id"]   = $id;
        $this->params         = $params + $this->params;
        return $this;
    }

    public function createScrollParams(string $scroll, $scroll_id)
    {
        $this->params              = []; //  only 2 params
        $this->params["scroll"]    = $scroll;
        $this->params["scroll_id"] = $scroll_id;
        return $this;
    }

    public function initializeBulkIndexing(string $index, array $options = [])
    {
        $this->index   = $index;
        $this->options = $options;
        $this->params  = ['body' => []];
        return $this;
    }

    public function addToBulkIndexing(string $id, array $data, $options = [])
    {

        $meta = [
            'index' => $options + [
                '_index' => $this->index,
                '_type'  => '_doc',
                '_id'    => $id,
            ] + $this->options,
        ];
        $this->params["body"][] = $meta;
        $this->params["body"][] = $data;

        return $this;
    }

    public function createCreateIndexParams(string $index, array $mappings = [])
    {
        $this->params = [
            'index' => $index,
            "body"  => [
                "mappings" => [
                    "_doc" => [
                        "properties" => $mappings,
                    ],
                ],
            ],
        ];
        return $this->elastic_client->indices()->create($this->params);
    }

    public function createDeleteIndexParams(string $index)
    {
        $this->params = ["index" => $index];
        return $this->elastic_client->indices()->delete($this->params);
    }

    public static function createAggMax(string $name, string $field)
    {
        return [$name => ["max" => ["field" => $field]]];
    }

    public static function createAggMin(string $name, string $field)
    {
        return [$name => ["min" => ["field" => $field]]];
    }

    public static function createAggSum(string $name, string $field)
    {
        return [$name => ["sum" => ["field" => $field]]];
    }

    public static function createAggTerms(string $name, string $field)
    {
        return [$name => ["terms" => ["field" => $field]]];
    }

    public static function createAggNested(string $name, string $path)
    {
        return [$name => ["nested" => ["path" => $path]]];
    }

    public static function addToAggregation(array $aggs, array $new_aggs)
    {
        $aggs[current(array_keys($aggs))]["aggs"] = $new_aggs;
        return $aggs;
    }

    public static function addMetric(array $aggs, array $metric)
    {
        return $aggs + $metric;
    }

    public function initAggregation()
    {
        if (!isset($this->params["body"])) {
            $this->setBody();
        };
        $this->params["body"]["aggs"] = [];
        return $this;
    }

    public function setAggregation(array $aggs)
    {
        $this->params["body"]["aggs"] = $aggs;
        return $this;
    }
}