<?php

namespace App;

use App\Jobs\DuplicateData;
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
        $sync_data      = Defaults::getLastSync();
        $raw_data       = self::fetch();
        $sanitized_data = collect(self::sanitize($raw_data));
        foreach ($sanitized_data->chunk(config('static.fetch_limit')) as $sanitized_batched_data) {
            dispatch(new IndexData($sanitized_batched_data))->onQueue('index_data');
        }
        self::checkForMoreData($sanitized_data->last()['call']['date'], $this->data->last()['call']['id']);
    }

    public static function checkForMoreData($date, $id)
    {
        Defaults::updateLastSync($date, $id);
        $last_data = \DB::connection('vicidial')->table('vicidial_log')->where('call_date', '>', $date)->get();
        if (count($last_data) > 0) {
            dispatch(new CreateIndexData())->onQueue('fetch_data');
        }
    }

    public static function CreateIndexData()
    {
        dispatch(new CreateIndexData())->onQueue('fetch_data');
    }

    public static function duplicateBatchData()
    {
        $log    = \DB::connection('vicidial')->table('vicidial_log')->orderBy('call_date', 'DESC')->limit(1)->first();
        $status = \DB::connection('vicidial')->table('vicidial_statuses')->pluck('status');
        $log    = json_decode(json_encode($log), true);

        for ($i = 0; $i < 5000; $i++) {
            $lead_ids             = [8, 9, 10];
            $phone                = ['7798870476', '8073726204', '7276874408'];
            $log['start_epoch']   = time() + $i;
            $log['end_epoch']     = time() + $i;
            $log['call_date']     = Carbon::parse($log['call_date'])->addDays(1);
            $log['lead_id']       = $lead_ids[rand(0, count($lead_ids) - 1)];
            $log['length_in_sec'] = rand(0, 2000);
            $log['status']        = $status[rand(0, count($status) - 1)];
            $log['phone_number']  = $phone[rand(0, count($phone) - 1)];
            $log['uniqueid']      = $log['start_epoch'] . '.' . str_pad($log['lead_id'], 9, "0", STR_PAD_LEFT);
            \DB::connection('vicidial')->table('vicidial_log')->insert($log);
        }
    }

    public static function duplicate()
    {
        for ($i = 0; $i < 20; $i++) {
            dispatch(new DuplicateData())->onQueue('duplicate_data');
        }
    }
}
