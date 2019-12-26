<?php
return [
    'agent'    => [
        'name'           => [
            'field' => 'vicidial_users.full_name',
            'type'  => 'string',
        ],
        'id'             => [
            'field' => 'vicidial_users.user_id',
            'type'  => 'string',
        ],
        'login_status'   => [
            'field' => '', //'vicidial_agent_log.sub_status',
            'type'  => 'string',
        ],
        'last_activity'  => [
            'field' => '',
            'type'  => 'string',
        ],
        'current_status' => [
            'field' => '',
            'type'  => 'string',
        ],
    ],
    'session'  => [
        /*'station'  => [
            'field' => 'vicidial_stations.agent_station',
            'type'  => 'string',
        ],*/
        'id' => [
            'field' => 'vicidial_session_data.session_name',
            'type'  => 'string',
        ],
    ],
    'call'     => [
        'id'                   => [
            'field' => 'vicidial_log.uniqueid',
            'type'  => 'string',
        ],
        'wait_time'            => [
            'field' => '',
            'type'  => 'string',
        ],
        'start_time'           => [
            'field' => 'vicidial_log.start_epoch',
            'type'  => 'date',
        ],
        'end_time'             => [
            'field' => 'vicidial_log.end_epoch',
            'type'  => 'date',
        ],
        'lead_status'          => [
            'field' => 'vicidial_list.status',
            'type'  => 'string',
        ],
        'desposition_assigned' => [
            'field' => 'vicidial_log.status',
            'type'  => 'string',
        ],
        'desposition_value'    => [
            'field' => 'vicidial_statuses.status_name',
            'type'  => 'string',
        ],
        'contact'              => [
            'field' => '',
            'type'  => 'string',
        ],
        'active_time_spent'    => [
            'field' => 'vicidial_log.length_in_sec',
            'type'  => 'string',
        ],
        'call_status'          => [
            'field' => 'vicidial_log.status',
            'type'  => 'string',
        ],
        'lasts_sync'           => [
            'field' => '',
            'type'  => 'string',
        ],
    ],
    'lead'     => [
        'id'                => [
            'field' => 'vicidial_log.lead_id',
            'type'  => 'string',
        ],
        'country_code'      => [
            'field' => 'vicidial_list.country_code',
            'type'  => 'string',
        ],
        'phone'             => [
            'field' => 'vicidial_list.phone_number',
            'type'  => 'string',
        ],
        'first_name'        => [
            'field' => 'vicidial_list.first_name',
            'type'  => 'string',
        ],
        'middle_name'       => [
            'field' => 'vicidial_list.middle_initial',
            'type'  => 'string',
        ],
        'last_name'         => [
            'field' => 'vicidial_list.last_name',
            'type'  => 'string',
        ],
        'owner'             => [
            'field' => 'vicidial_list.owner',
            'type'  => 'string',
        ],
        'rank'              => [
            'field' => 'vicidial_list.rank',
            'type'  => 'string',
        ],
        'invalid'           => [
            'field' => '',
            'type'  => 'string',
        ],
        'valid'             => [
            'field' => '',
            'type'  => 'string',
        ],
        'non-british'       => [
            'field' => '',
            'type'  => 'string',
        ],
        'dialable'          => [
            'field' => '',
            'type'  => 'string',
        ],
        'quantity_eu'       => [
            'field' => '',
            'type'  => 'string',
        ],
        'lead-subscription' => [
            'field' => '',
            'type'  => 'string',
        ],
        'clean-lines'       => [
            'field' => '',
            'type'  => 'string',
        ],
        'dial_type'         => [
            'field' => 'vicidial_log.alt_dial',
            'type'  => 'string',
        ],
    ],
    'campaign' => [
        'name'            => [
            'field' => 'vicidial_campaigns.campaign_name',
            'type'  => 'string',
        ],
        'id'              => [
            'field' => 'vicidial_campaigns.campaign_id',
            'type'  => 'string',
        ],
        'dial_level'      => [
            'field' => 'vicidial_campaigns.auto_dial_level',
            'type'  => 'string',
        ],
        'hopper_setting'  => [
            'field' => 'vicidial_campaigns.hopper_level',
            'type'  => 'string',
        ],
        'no_hopper_leads' => [
            'field' => 'vicidial_campaigns.no_hopper_leads_logins',
            'type'  => 'string',
        ],
        'lead_filter'     => [
            'field' => 'vicidial_campaigns.lead_filter_id',
            'type'  => 'string',
        ],
        'dial_method'     => [
            'field' => '',
            'type'  => 'string',
        ],
        'list_order'      => [
            'field' => 'vicidial_campaigns.lead_order',
            'type'  => 'string',
        ],
    ],
    'list'     => [
        'name'                 => [
            'field' => 'vicidial_lists.list_name',
            'type'  => 'string',
        ],
        'id'                   => [
            'field' => 'vicidial_lists.list_id',
            'type'  => 'string',
        ],
        'status'               => [
            'field' => 'vicidial_lists.active',
            'type'  => 'string',
        ],
        'expiration_date'      => [
            'field' => 'vicidial_lists.expiration_date',
            'type'  => 'string',
        ],
        'total_number_records' => [
            'field' => '',
            'type'  => 'string',
        ],
        'duplicate_records'    => [
            'field' => '',
            'type'  => 'string',
        ],
    ],
];
