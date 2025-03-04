<?php

return [
  'name' => 'Base',
  'admin_dir' => 'cmspanel',
  'base_name' => env('APP_NAME', 'Louis Technologies'),
  'cache_site_map' => false,
  'cache' => [
    'use_cache' => false,
    'cache_key' => 'cms-sitemap.' . config('app.url'),
    'cache_duration' => 3600,
    'escaping' => true,
    'use_limit_size' => false,
    'max_size' => null,
    'use_styles' => true,
    'styles_location' => '/vendor/core/modules/sitemap/styles/',
    'use_gzip' => false,
  ],
  'bulk_actions' => [
    '0' => 'Bulk Action',
    'publish' => 'Kích hoạt',
    'draft' => 'Chưa kích hoạt',
    'trash' => 'Xoá tạm',
    'restore' => 'Khôi phục',
    'delete' => 'Xoá vĩnh viễn',
  ],
  'ignored_bots' => [
    'googlebot', // Googlebot
    'bingbot', // Microsoft Bingbot
    'slurp', // Yahoo! Slurp
    'ia_archiver', // Alexa
  ],
  'date_format'   => [
      'date'      => env('CMS_DATE_FORMAT', 'Y-m-d'),
      'date_time' => env('CMS_DATE_TIME_FORMAT', 'd/m/Y H:i:s'),
      'js'        => [
          'date'      => env('CMS_JS_DATE_FORMAT', 'yyyy-mm-dd'),
          'date_time' => env('CMS_JS_DATE_TIME_FORMAT', 'yyyy-mm-dd H:i:s'),
      ],
  ],
  'general'  => [
    'enable_less_secure_web' => env('CMS_ENABLE_LESS_SECURE_WEB', false),
  ] 
];
