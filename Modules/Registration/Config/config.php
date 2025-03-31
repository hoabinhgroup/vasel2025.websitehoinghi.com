<?php

return [
    'name' => 'Registration',
    'speaker-registration-vn' => 'SRV',
    'speaker-registration' => 'SR',
    'invitee-registration-vn' => 'IRV',
    'invitee-registration' => 'IR',
    'email' => [
        'endpoint' => 'https://hoabinhclub.com/api/email/service',
        'code' => 'VASEL2025',
        'cc' => [
            [
                'hoabinhwebmaster@gmail.com',
                'VASEL 2025',
            ],
        ],
        'sending_server' => 25,
        'from_email' => 'hoithao@hoabinh-group.com',
        'from_name' => 'hoithao@hoabinh-group.com',
        'subject' => 'VASEL 2025 - Đăng ký báo cáo thành công ',
        'reply_to' => 'hoithao@hoabinh-group.com'
    ]
];
