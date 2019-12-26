<?php

namespace App;

use App\Jobs\IndexData;

class Vicidial
{
    private static $mapping = [
        'agent'    => [
            'name'           => 'vicidial_users.full_name',
            'id'             => 'vicidial_users.user_id',
            'login_status'   => '', //'vicidial_agent_log.sub_status',
            'last_activity'  => '',
            'current_status' => '',
        ],
        'session'  => [
            //         'station' => 'vicidial_stations.agent_station',
            'id' => 'vicidial_session_data.session_name',
        ],
        'call'     => [
            'id'                   => 'vicidial_log.uniqueid',
            'wait_time'            => '',
            'start_time'           => 'vicidial_log.start_epoch',
            'end_time'             => 'vicidial_log.end_epoch',
            'lead_status'          => 'vicidial_list.status',
            'desposition_assigned' => 'vicidial_log.status',
            'desposition_value'    => 'vicidial_statuses.status_name',
            'contact'              => '',
            'active_time_spent'    => 'vicidial_log.length_in_sec',
            'call_status'          => 'vicidial_log.status',
            'lasts_sync'           => '',
        ],
        'lead'     => [
            'id'                => 'vicidial_log.lead_id',
            'country_code'      => 'vicidial_list.country_code',
            'phone'             => 'vicidial_list.phone_number',
            'first_name'        => 'vicidial_list.first_name',
            'middle_name'       => 'vicidial_list.middle_initial',
            'last_name'         => 'vicidial_list.last_name',
            'owner'             => 'vicidial_list.owner',
            'rank'              => 'vicidial_list.rank',
            'invalid'           => '',
            'valid'             => '',
            'non-british'       => '',
            'dialable'          => '',
            'quantity_eu'       => '',
            'lead-subscription' => '',
            'clean-lines'       => '',
            'dial_type'         => 'vicidial_log.alt_dial',
        ],
        'campaign' => [
            'name'            => 'vicidial_campaigns.campaign_name',
            'id'              => 'vicidial_campaigns.campaign_id',
            'dial_level'      => 'vicidial_campaigns.auto_dial_level',
            'hopper_setting'  => 'vicidial_campaigns.hopper_level',
            'no_hopper_leads' => 'vicidial_campaigns.no_hopper_leads_logins',
            'lead_filter'     => 'vicidial_campaigns.lead_filter_id',
            'dial_method'     => '',
            'list_order'      => 'vicidial_campaigns.lead_order',
        ],
        'list'     => [
            'name'                 => 'vicidial_lists.list_name',
            'id'                   => 'vicidial_lists.list_id',
            'status'               => 'vicidial_lists.active',
            'expiration_date'      => 'vicidial_lists.expiration_date',
            'total_number_records' => '',
            'duplicate_records'    => '',
        ],
    ];

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
            ->select(collect(self::$mapping)->flatten()->filter()->values()->map(function ($field) {
                return $field . ' as ' . $field;
            })->toArray())
            ->get();

        return $data;
    }

    public static function sanitize($raw_data)
    {
        $sanitized_data = collect();
        foreach ($raw_data as $single_data) {
            $mapping = self::$mapping;
            foreach ($mapping as $entity => &$entity_data) {
                foreach ($entity_data as $name => &$field) {
                    if ($field) {
                        $field = $single_data->{$field};
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
