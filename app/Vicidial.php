<?php

namespace App;

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
            'station' => 'vicidial_stations.agent_station',
            'id'      => 'vicidial_session_data.session_name',
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
    	foreach(collect($data)->flatten()->filter()->values() as $field){
    		$field_arr = explode('.', $field); 
    		$fields_by_table[$field_arr[0]][] = $field;
    	}

        $log = \DB::connection('vicidial')->table('vicidial_log')->get();
        collect($log)->chunk(10)->each(function($chunked_log) use ($fields_by_table){
        	$fields_by_table = collect($fields_by_table);
        	$campaign_ids = collect($chunked_log)->pluck('campaign_id');
        	$list_ids = collect($chunked_log)->pluck('list_id');
        	$lead_ids = collect($chunked_log)->pluck('lead_id');
        	$status_ids = collect($chunked_log)->pluck('status');

        	$campaigns = \DB::connection('vicidial')->table('vicidial_campaigns')->whereIn('campaign_id', $campaign_ids)->get($field_by_table['vicidial_campaigns']);
        	$lists = \DB::connection('vicidial')->table('vicidial_lists')->whereIn('list_id', $list_ids)->get($field_by_table['vicidial_lists']);
        	$leads = \DB::connection('vicidial')->table('vicidial_list')->whereIn('lead_id', $lead_ids)->get($field_by_table['vicidial_list']);
        	$statuses = \DB::connection('vicidial')->table('vicidial_statuses')->whereIn('status', $status_ids)->get($field_by_table['vicidial_statuses']);
        	$response_data = (object)array_merge_recursive((array)$chunked_log, (array)$campaigns, (array)$lists, (array)$leads, (array)$statuses);
        });
        return $response_data;
    }

    public static function sanitze()
    {

    }
}
