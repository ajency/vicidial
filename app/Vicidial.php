<?php

namespace App;

use App\Jobs\CreateIndexData;
use App\Jobs\IndexData;
use Carbon\Carbon;

class Vicidial
{
    public static function fetch()
    {
        $sync_data = Defaults::getLastSync();
        $query     = \DB::connection('vicidial')->table('vicidial_log')
            ->join('vicidial_users', 'vicidial_users.user', '=', 'vicidial_log.user')
            ->join('vicidial_campaigns', 'vicidial_log.campaign_id', '=', 'vicidial_campaigns.campaign_id')
            ->join('vicidial_lists', 'vicidial_log.list_id', '=', 'vicidial_lists.list_id')
            ->join('vicidial_list', 'vicidial_list.lead_id', '=', 'vicidial_log.lead_id')
            ->join('vicidial_statuses', 'vicidial_statuses.status', '=', 'vicidial_log.status')
            ->join('vicidial_session_data', function ($join) {
                $join->on('vicidial_session_data.user', '=', 'vicidial_log.user')
                    ->on('vicidial_session_data.campaign_id', '=', 'vicidial_log.campaign_id');
            });
        if (isset($sync_data['log_time'])) {
            $query->where('vicidial_log.call_date', '>', $sync_data['log_time']);
        }
        $query->limit(config('static.fetch_limit'));
        $db_fields = collect(config('field_mapping'))->flatten(1)->map(function ($field_data) {
            if ($field_data['source'] == 'database' && $field_data['field'] != '') {
                return $field_data['field'] . ' as ' . $field_data['field'];
            }})->filter()->values()->toArray();
        $data = $query->select($db_fields)->get();
        foreach ($data as &$log) {
            $unique_list_count      = \DB::connection('vicidial')->table('vicidial_list')->where('list_id', $log->{'vicidial_lists.list_id'})->groupBy('phone_number')->count();
            $total_list_count       = \DB::connection('vicidial')->table('vicidial_list')->where('list_id', $log->{'vicidial_lists.list_id'})->count();
            $log->total_records     = $unique_list_count;
            $log->duplicate_records = $total_list_count - $unique_list_count;
        }
        return $data;
    }

    public static function sanitize($raw_data)
    {
        $sanitized_data = collect();
        foreach ($raw_data as $single_data) {
            $mapping = config('field_mapping');
            foreach ($mapping as $entity => &$entity_data) {
                foreach ($entity_data as $name => &$field_data) {
                    if ($field_data['field']) {
                        if ($field_data['type'] == 'date') {
                            $field_data = Carbon::createFromTimestamp($single_data->{$field_data['field']})->toDateTimeString();
                        } else {
                            $field_data = $single_data->{$field_data['field']};
                        }
                    } else {
                        $field_data = '';
                    }
                }
            }
            $sanitized_data->push($mapping);
        }
        return $sanitized_data;
    }

    public static function index()
    {
        $raw_data       = self::fetch();
        $sanitized_data = collect(self::sanitize($raw_data));
        foreach ($sanitized_data->chunk(config('static.fetch_limit')) as $sanitized_batched_data) {
            dispatch(new IndexData($sanitized_batched_data))->onQueue('index_data');
        }

        self::checkForMoreData($sanitized_data->last()['call']['date'], $sanitized_data->last()['call']['id']);
    }

    public static function checkForMoreData($date, $id)
    {
        Defaults::updateLastSync($date, $id);
        $last_data = \DB::connection('vicidial')->table('vicidial_log')->where('call_date', '>', $date)->get();
        if (count($last_data) > 0) {
            dispatch(new CreateIndexData())->onQueue('fetch_data');
        }
    }

    public static function createIndexData()
    {
        dispatch(new CreateIndexData())->onQueue('fetch_data');
    }
}
