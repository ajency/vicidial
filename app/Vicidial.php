<?php

namespace App;

use App\Jobs\IndexData;

class Vicidial
{
    public static function fetch()
    {
        $data = \DB::connection('vicidial')->table('vicidial_log')
            ->join('vicidial_users', 'vicidial_users.user', '=', 'vicidial_log.user')
            ->join('vicidial_campaigns', 'vicidial_log.campaign_id', '=', 'vicidial_campaigns.campaign_id')
            ->join('vicidial_lists', 'vicidial_log.list_id', '=', 'vicidial_lists.list_id')
            ->join('vicidial_list', 'vicidial_list.lead_id', '=', 'vicidial_log.lead_id')
            ->join('vicidial_statuses', 'vicidial_statuses.status', '=', 'vicidial_log.status')
            ->join('vicidial_session_data', function ($join) {
                $join->on('vicidial_session_data.user', '=', 'vicidial_log.user')
                    ->on('vicidial_session_data.campaign_id', '=', 'vicidial_log.campaign_id');
            })
            ->select(collect(config('field_mapping'))->flatten()->filter()->values()->map(function ($field) {
                return $field . ' as ' . $field;
            })->toArray())
            ->get();

        return $data;
    }

    public static function sanitize($raw_data)
    {
        $sanitized_data = collect();
        foreach ($raw_data as $single_data) {
            $mapping = config('field_mapping');
            foreach ($mapping as $entity => &$entity_data) {
                foreach ($entity_data as $name => &$field) {
                    if ($field) {
                        if ($name) {
                            $field = $single_data->{$field};
                        }

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
        $sanitized_data = self::sanitize($raw_data);
        foreach (collect($sanitized_data)->chunk(10) as $sanitized_batched_data) {
            dispatch(new IndexData($sanitized_batched_data));
        }
    }
}
