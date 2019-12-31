<?php
return [
    'agent'    => [
        'name'           => [
            'field'  => 'vicidial_users.full_name',
            'fetch'  => 'vicidial_users_full_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'id'             => [
            'field'  => 'vicidial_users.user_id',
            'fetch'  => 'vicidial_users_user_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'login_status'   => [
            'field'  => '', //'vicidial_agent_log.sub_status',
            'fetch'  => '', //'vicidial_agent_log_sub_status',
            'type'   => 'string',
            'source' => 'database',
        ],
        'last_login'     => [
            'field'  => 'vicidial_users.last_login_date',
            'fetch'  => 'vicidial_users_last_login_date',
            'type'   => 'string',
            'source' => 'database',
        ],
        'current_status' => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'session'  => [
        /*'station'  => [
        'field' => 'vicidial_stations.agent_station',
        'fetch' =>  'vicidial_stations_agent_station',
        'type'  => 'string',
        'source' => 'database'        ],*/
        'id' => [
            'field'  => 'vicidial_session_data.session_name',
            'fetch'  => 'vicidial_session_data_session_name',
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'call'     => [
        'id'                   => [
            'field'  => 'vicidial_log.uniqueid',
            'fetch'  => 'vicidial_log_uniqueid',
            'type'   => 'string',
            'source' => 'database',
        ],
        'date'                 => [
            'field'  => 'vicidial_log.call_date',
            'fetch'  => 'vicidial_log_call_date',
            'type'   => 'string',
            'source' => 'database',
        ],
        'wait_time'            => [
            'field'  => '',
            'fetch'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'start_time'           => [
            'field'  => 'vicidial_log.start_epoch',
            'fetch'  => 'vicidial_log_start_epoch',
            'type'   => 'date',
            'source' => 'database',
        ],
        'end_time'             => [
            'field'  => 'vicidial_log.end_epoch',
            'fetch'  => 'vicidial_log_end_epoch',
            'type'   => 'date',
            'source' => 'database',
        ],
        'lead_status'          => [
            'field'  => 'vicidial_list.status',
            'fetch'  => 'vicidial_list_status',
            'type'   => 'string',
            'source' => 'database',
        ],
        'desposition_assigned' => [
            'field'  => 'vicidial_log.status',
            'fetch'  => 'vicidial_log_status',
            'type'   => 'string',
            'source' => 'database',
        ],
        'desposition_value'    => [
            'field'  => 'vicidial_statuses.status_name',
            'fetch'  => 'vicidial_statuses_status_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'contact'              => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'active_time_spent'    => [
            'field'  => 'vicidial_log.length_in_sec',
            'fetch'  => 'vicidial_log_length_in_sec',
            'type'   => 'string',
            'source' => 'database',
        ],
        'call_status'          => [
            'field'  => 'vicidial_log.status',
            'fetch'  => 'vicidial_log_status',
            'type'   => 'string',
            'source' => 'database',
        ],
        'lasts_sync'           => [
            'field'  => '',
            'fetch'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'lead'     => [
        'id'                => [
            'field'  => 'vicidial_log.lead_id',
            'fetch'  => 'vicidial_log_lead_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'country_code'      => [
            'field'  => 'vicidial_list.country_code',
            'fetch'  => 'vicidial_list_country_code',
            'type'   => 'string',
            'source' => 'database',
        ],
        'phone'             => [
            'field'  => 'vicidial_list.phone_number',
            'fetch'  => 'vicidial_list_phone_number',
            'type'   => 'string',
            'source' => 'database',
        ],
        'first_name'        => [
            'field'  => 'vicidial_list.first_name',
            'fetch'  => 'vicidial_list_first_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'middle_name'       => [
            'field'  => 'vicidial_list.middle_initial',
            'fetch'  => 'vicidial_list_middle_initial',
            'type'   => 'string',
            'source' => 'database',
        ],
        'last_name'         => [
            'field'  => 'vicidial_list.last_name',
            'fetch'  => 'vicidial_list_last_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'owner'             => [
            'field'  => 'vicidial_list.owner',
            'fetch'  => 'vicidial_list_owner',
            'type'   => 'string',
            'source' => 'database',
        ],
        'rank'              => [
            'field'  => 'vicidial_list.rank',
            'fetch'  => 'vicidial_list_rank',
            'type'   => 'string',
            'source' => 'database',
        ],
        'invalid'           => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'valid'             => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'non-british'       => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'dialable'          => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'quantity_eu'       => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'lead-subscription' => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'clean-lines'       => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'dial_type'         => [
            'field'  => 'vicidial_log.alt_dial',
            'fetch'  => 'vicidial_log_alt_dial',
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'campaign' => [
        'name'            => [
            'field'  => 'vicidial_campaigns.campaign_name',
            'fetch'  => 'vicidial_campaigns_campaign_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'id'              => [
            'field'  => 'vicidial_campaigns.campaign_id',
            'fetch'  => 'vicidial_campaigns_campaign_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'dial_level'      => [
            'field'  => 'vicidial_campaigns.auto_dial_level',
            'fetch'  => 'vicidial_campaigns_auto_dial_level',
            'type'   => 'string',
            'source' => 'database',
        ],
        'hopper_setting'  => [
            'field'  => 'vicidial_campaigns.hopper_level',
            'fetch'  => 'vicidial_campaigns_hopper_level',
            'type'   => 'string',
            'source' => 'database',
        ],
        'no_hopper_leads' => [
            'field'  => 'vicidial_campaigns.no_hopper_leads_logins',
            'fetch'  => 'vicidial_campaigns_no_hopper_leads_logins',
            'type'   => 'string',
            'source' => 'database',
        ],
        'lead_filter'     => [
            'field'  => 'vicidial_campaigns.lead_filter_id',
            'fetch'  => 'vicidial_campaigns_lead_filter_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'dial_method'     => [
            'field'  => 'vicidial_campaigns.dial_method',
            'fetch'  => 'vicidial_campaigns_dial_method',
            'type'   => 'string',
            'source' => 'database',
        ],
        'list_order'      => [
            'field'  => 'vicidial_campaigns.lead_order',
            'fetch'  => 'vicidial_campaigns_lead_order',
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'list'     => [
        'name'              => [
            'field'  => 'vicidial_lists.list_name',
            'fetch'  => 'vicidial_lists_list_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'id'                => [
            'field'  => 'vicidial_lists.list_id',
            'fetch'  => 'vicidial_lists_list_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'status'            => [
            'field'  => 'vicidial_lists.active',
            'fetch'  => 'vicidial_lists_active',
            'type'   => 'string',
            'source' => 'database',
        ],
        'expiration_date'   => [
            'field'  => 'vicidial_lists.expiration_date',
            'fetch'  => 'vicidial_lists_expiration_date',
            'type'   => 'string',
            'source' => 'database',
        ],
        'total_records'     => [
            'field'  => 'total_records',
            'fetch'  => 'total_records',
            'type'   => 'string',
            'source' => 'code',
        ],
        'duplicate_records' => [
            'field'  => 'duplicate_records',
            'fetch'  => 'duplicate_records',
            'type'   => 'string',
            'source' => 'code',
        ],
    ],
];
