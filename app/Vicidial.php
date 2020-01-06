<?php

namespace App;

use Ajency\Connections\ElasticQuery;
use App\Jobs\CreateIndexData;
use App\Jobs\IndexData;
use Carbon\Carbon;

class Vicidial
{
    public static function fetch($date)
    {
        $db_fields = collect(config('field_mapping'))->flatten(1)->map(function ($field_data) {
            if ($field_data['field'] != '') {
                return $field_data['field'] . " as '" . $field_data['field'] . "'";
            }
        })->filter()->values()->implode(',');
        $query_string = "select " . $db_fields . " from vicidial_log inner join vicidial_list on vicidial_list.lead_id = vicidial_log.lead_id inner join vicidial_users on vicidial_users.user = vicidial_log.user inner join vicidial_campaigns on vicidial_log.campaign_id = vicidial_campaigns.campaign_id inner join vicidial_lists on vicidial_log.list_id = vicidial_lists.list_id inner join vicidial_statuses on vicidial_statuses.status = vicidial_log.status inner join vicidial_session_data on vicidial_session_data.user = vicidial_log.user and vicidial_session_data.campaign_id = vicidial_log.campaign_id left join (select list_id, sum(countx) as 'duplicate_records', count(*) as 'total_records' FROM (select phone_number, list_id,if(count(*)>1,1,0) as countx from vicidial_list group by phone_number,list_id) as count_table GROUP BY list_id) as list_join on list_join.list_id = vicidial_log.list_id";
        if ($date) {
            $query_string .= " where vicidial_log.call_date >= '" . $date . "'";
        }
        $query_string .= ' limit ' . config('static.fetch_limit');

        $data = \DB::connection('vicidial')->select($query_string);
        return $data;
    }

    public static function sanitize($raw_data)
    {
        $sanitized_data = collect();
        foreach ($raw_data as $single_data) {
            $mapping = config('field_mapping');
            foreach ($mapping as $entity => $entity_data) {
                foreach ($entity_data as $name => $field_data) {
                    if ($field_data['field']) {
                        if ($field_data['type'] == 'date' && $field_data['format'] == 'timestamp') {
                            $sanitized_single_data[$entity . '_' . $name] = Carbon::createFromTimestamp($single_data->{$field_data['field']})->timestamp;
                        } elseif ($field_data['type'] == 'date') {
                            $sanitized_single_data[$entity . '_' . $name] = Carbon::parse($single_data->{$field_data['field']})->timestamp;
                        } else {
                            $sanitized_single_data[$entity . '_' . $name] = $single_data->{$field_data['field']};
                        }
                    } else {
                        $sanitized_single_data[$entity . '_' . $name] = '';
                    }
                }
            }
            $sanitized_data->push($sanitized_single_data);
        }
        return $sanitized_data;
    }

    public static function buildData($last_date)
    {
        $sync_data = Defaults::getCronStatus();
        if ($sync_data['run_cron']) {
            $start_time     = Carbon::now();
            $date           = Carbon::createFromTimestamp($last_date)->toDateTimeString();
            $raw_data       = self::fetch($date);
            $sanitized_data = collect(self::sanitize($raw_data));
            if (count($sanitized_data) > 0) {
                foreach ($sanitized_data->chunk(config('static.index_limit')) as $sanitized_batched_data) {
                    dispatch(new IndexData($sanitized_batched_data))->onQueue('index_data');
                }
                self::checkForMoreData($sanitized_data->last()['call_date'], $sanitized_data->last()['call_id'], $start_time);
            }
        }
    }

    public static function checkForMoreData($date, $id, $start_time)
    {
        Defaults::updateLastSync($date, $id, $start_time);
        dispatch(new CreateIndexData($date))->onQueue('fetch_data');
    }

    public static function createIndexData()
    {
        $sync_data = Defaults::getLastSync();
        $date      = isset($sync_data['log_time']) ? $sync_data['log_time'] : null;
        dispatch(new CreateIndexData($date))->onQueue('fetch_data');
    }

    public static function index($data)
    {
        $query = new ElasticQuery;
        $query->setIndex(config('elastic.indexes.call'));
        $query->initializeBulkIndexing();
        $data->each(function ($item, $key) use ($query) {
            $query->addToBulkIndexing($item['call_id'], $item);
        });
        $responses = $query->bulk();
    }
}
