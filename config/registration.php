<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Registration Settings
    |--------------------------------------------------------------------------
    |
    | Here you may specify the registration settings for your application.
    |
    */

    'enabled' => env('REGISTRATION_ENABLED', false),

    'speaker_registration_enabled' => env('SPEAKER_REGISTRATION_ENABLED', false),
    'delegate_registration_enabled' => env('DELEGATE_REGISTRATION_ENABLED', false),

    'close_message' => [
        'en' => 'The registration period for VASEL 2025 has ended. We apologize for any inconvenience.',
        'vn' => 'Thời gian đăng ký cho VASEL 2025 đã kết thúc. Chúng tôi xin lỗi vì sự bất tiện này.'
    ]
];
