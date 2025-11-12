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
        'en' => 'Online registration for the VASEL 2025 Conference is now closed.',
        'vn' => 'Cổng đăng ký trực tuyến Hội nghị VASEL 2025 đã đóng. Trân trọng cảm ơn sự quan tâm của Quý vị.'
    ]
];
