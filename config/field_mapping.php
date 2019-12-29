<?php
return [
    'agent'    => [
        'name'           => [
            'field'  => 'vicidial_users.full_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'id'             => [
            'field'  => 'vicidial_users.user_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'login_status'   => [
            'field'  => '', //'vicidial_agent_log.sub_status',
            'type'   => 'string',
            'source' => 'database',
        ],
        'last_login'     => [
            'field'  => 'vicidial_users.last_login_date',
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
        'type'  => 'string',
        'source' => 'database'        ],*/
        'id' => [
            'field'  => 'vicidial_session_data.session_name',
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'call'     => [
        'id'                   => [
            'field'  => 'vicidial_log.uniqueid',
            'type'   => 'string',
            'source' => 'database',
        ],
        'date'                 => [
            'field' => 'vicidial_log.call_date',
            'type'  => 'string',
        ],
        'wait_time'            => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
        'start_time'           => [
            'field'  => 'vicidial_log.start_epoch',
            'type'   => 'date',
            'source' => 'database',
        ],
        'end_time'             => [
            'field'  => 'vicidial_log.end_epoch',
            'type'   => 'date',
            'source' => 'database',
        ],
        'lead_status'          => [
            'field'  => 'vicidial_list.status',
            'type'   => 'string',
            'source' => 'database',
        ],
        'desposition_assigned' => [
            'field'  => 'vicidial_log.status',
            'type'   => 'string',
            'source' => 'database',
        ],
        'desposition_value'    => [
            'field'  => 'vicidial_statuses.status_name',
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
            'type'   => 'string',
            'source' => 'database',
        ],
        'call_status'          => [
            'field'  => 'vicidial_log.status',
            'type'   => 'string',
            'source' => 'database',
        ],
        'lasts_sync'           => [
            'field'  => '',
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'lead'     => [
        'id'                => [
            'field'  => 'vicidial_log.lead_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'country_code'      => [
            'field'  => 'vicidial_list.country_code',
            'type'   => 'string',
            'source' => 'database',
        ],
        'phone'             => [
            'field'  => 'vicidial_list.phone_number',
            'type'   => 'string',
            'source' => 'database',
        ],
        'first_name'        => [
            'field'  => 'vicidial_list.first_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'middle_name'       => [
            'field'  => 'vicidial_list.middle_initial',
            'type'   => 'string',
            'source' => 'database',
        ],
        'last_name'         => [
            'field'  => 'vicidial_list.last_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'owner'             => [
            'field'  => 'vicidial_list.owner',
            'type'   => 'string',
            'source' => 'database',
        ],
        'rank'              => [
            'field'  => 'vicidial_list.rank',
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
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'campaign' => [
        'name'            => [
            'field'  => 'vicidial_campaigns.campaign_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'id'              => [
            'field'  => 'vicidial_campaigns.campaign_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'dial_level'      => [
            'field'  => 'vicidial_campaigns.auto_dial_level',
            'type'   => 'string',
            'source' => 'database',
        ],
        'hopper_setting'  => [
            'field'  => 'vicidial_campaigns.hopper_level',
            'type'   => 'string',
            'source' => 'database',
        ],
        'no_hopper_leads' => [
            'field'  => 'vicidial_campaigns.no_hopper_leads_logins',
            'type'   => 'string',
            'source' => 'database',
        ],
        'lead_filter'     => [
            'field'  => 'vicidial_campaigns.lead_filter_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'dial_method'     => [
            'field'  => 'vicidial_campaigns.dial_method',
            'type'   => 'string',
            'source' => 'database',
        ],
        'list_order'      => [
            'field'  => 'vicidial_campaigns.lead_order',
            'type'   => 'string',
            'source' => 'database',
        ],
    ],
    'list'     => [
        'name'              => [
            'field'  => 'vicidial_lists.list_name',
            'type'   => 'string',
            'source' => 'database',
        ],
        'id'                => [
            'field'  => 'vicidial_lists.list_id',
            'type'   => 'string',
            'source' => 'database',
        ],
        'status'            => [
            'field'  => 'vicidial_lists.active',
            'type'   => 'string',
            'source' => 'database',
        ],
        'expiration_date'   => [
            'field'  => 'vicidial_lists.expiration_date',
            'type'   => 'string',
            'source' => 'database',
        ],
        'total_records'     => [
            'field'  => 'total_records',
            'type'   => 'string',
            'source' => 'code',
        ],
        'duplicate_records' => [
            'field'  => 'duplicate_records',
            'type'   => 'string',
            'source' => 'code',
        ],
    ],
];
