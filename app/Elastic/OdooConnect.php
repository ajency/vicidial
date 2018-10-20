<?php
namespace App\Elastic;

use Ripcord\Ripcord;

class OdooConnect
{

    protected $connections = [];
    protected $URL         = "";
    protected $DB          = "";

    protected $common;
    protected $model;

    public function __construct()
    {
        $this->connections = config('esconfig.connections');
        $this->URL         = config('esconfig.url');
        $this->DB          = config('esconfig.db');
        $this->limit       = intval(config('esconfig.limit'));

        $this->common = Ripcord::client("{$this->URL}/xmlrpc/2/common");
        $this->models = Ripcord::client("{$this->URL}/xmlrpc/2/object");

        foreach ($this->connections as &$connection) {
            $connection['user_id'] = $this->common->authenticate($this->DB, $connection["username"], $connection["password"], []);
        }
    }

    public function getConnections()
    {
        return $this->connections;
    }

    public function defaultConn()
    {
        return $this->connections[0];
    }

    public function defaultExec($model, $method, $filters, $attributes = [])
    {
        if (!isset($attributes['limit']) && $method != 'read') {
            $attributes['limit'] = config('esconfig.limit');
        }

        \Log::info($filters);
        \Log::info($attributes);
        $data = collect($this->models->execute_kw(
            $this->DB,
            $this->defaultConn()['user_id'],
            $this->defaultConn()['password'],
            $model, $method, $filters, $attributes
        ));

        \Log::info('odoo data from ' . $model . ' with user ' . $this->defaultConn()['username'] . ': ' . $data);
        return $data;
    }

    public function multiExec($model, $method, $filters, $attributes = [])
    {
        if (!isset($attributes['limit']) && $method != 'read') {
            $attributes['limit'] = config('esconfig.limit');
        }

        \Log::info($filters);
        \Log::info($attributes);
        $data = collect();
        foreach ($this->connections as $connection) {
            $data->put($connection['username'], collect($this->models->execute_kw(
                $this->DB,
                $connection['user_id'],
                $connection['password'],
                $model, $method, $filters, $attributes
            ));
                \Log::info('odoo data from ' . $model . ' with user ' . $connection['username'] . ': ' . $data[$connection['username']]);
            }
        }

    }
