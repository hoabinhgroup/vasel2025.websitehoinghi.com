<?php

return [
    'sizes'                   => [
        'thumb' => '150x150',
        'featured' => '500x250',
        'medium' => '750x500'
    ],
    'permissions'             => [
        'folders.create',
        'folders.edit',
        'folders.trash',
        'folders.destroy',
        'files.create',
        'files.edit',
        'files.trash',
        'files.destroy',
        'files.favorite',
        'folders.favorite',
    ],
    'libraries'               => [
        'stylesheets' => [
            'vendor/core/modules/media/css/toastr.min.css',
            'vendor/core/modules/media/libraries/fancybox/jquery.fancybox.min.css',
            'vendor/core/modules/media/libraries/jquery-context-menu/jquery.contextMenu.min.css',
            'vendor/core/modules/media/css/media.css?v=' . time(),
        ],
        'javascript'  => [
            'vendor/core/modules/media/js/toastr.min.js',
            'vendor/core/modules/media/libraries/fancybox/jquery.fancybox.min.js',
            'vendor/core/modules/media/libraries/lodash/lodash.min.js',
            'vendor/core/modules/media/libraries/clipboard/clipboard.min.js',
            'vendor/core/modules/media/libraries/dropzone/dropzone.js',
            'vendor/core/modules/media/libraries/jquery-context-menu/jquery.ui.position.min.js',
            'vendor/core/modules/media/libraries/jquery-context-menu/jquery.contextMenu.min.js',
            'vendor/core/modules/media/js/media.js?v=' . time(),
        ],
    ],
    'allowed_mime_types'      => env('LOUIS_MEDIA_ALLOWED_MIME_TYPES',
        'jpg,jpeg,png,gif,txt,docx,zip,mp3,bmp,csv,xls,xlsx,ppt,pptx,pdf,mp4,doc,mpga,wav'),
    'mime_types'              => [
        'image'    => [
            'image/png',
            'image/jpeg',
            'image/gif',
            'image/bmp',
        ],
        'video'    => [
            'video/mp4',
        ],
        'document' => [
            'application/pdf',
            'application/vnd.ms-excel',
            'application/excel',
            'application/x-excel',
            'application/x-msexcel',
            'text/plain',
            'application/msword',
            'text/csv',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ],
    ],
    'chunk' => [
        'enabled' => env('LOUIS_MEDIA_UPLOAD_CHUNK', false),
        'chunk_size' => 1024 * 1024, // Bytes
        'max_file_size' => 1024 * 1024, // MB
    
        /*
         * The storage config
         */
        'storage' => [
            /*
             * Returns the folder name of the chunks. The location is in storage/app/{folder_name}
             */
            'chunks' => 'chunks',
            'disk' => 'local',
        ],
        'clear' => [
            /*
             * How old chunks we should delete
             */
            'timestamp' => '-3 HOURS',
            'schedule' => [
                'enabled' => true,
                'cron' => '25 * * * *', // run every hour on the 25th minute
            ],
        ],
        'chunk' => [
            // setup for the chunk naming setup to ensure same name upload at same time
            'name' => [
                'use' => [
                    'session' => true, // should the chunk name use the session id? The uploader must send cookie!,
                    'browser' => false, // instead of session we can use the ip and browser?
                ],
            ],
        ],
    ],
    'default_image'           => env('LOUIS_MEDIA_DEFAULT_IMAGE', '/vendor/core/modules/images/placeholder.png'),
    'sidebar_display'         => env('LOUIS_MEDIA_SIDEBAR_DISPLAY', 'horizontal'), // Use "vertical" or "horizontal"
    'watermark'               => [
        'source'   => env('LOUIS_MEDIA_WATERMARK_SOURCE'),
        'position' => env('LOUIS_MEDIA_WATERMARK_POSITION', 'bottom-right'),
        'x'        => env('LOUIS_MEDIA_WATERMARK_X', 10),
        'y'        => env('LOUIS_MEDIA_WATERMARK_Y', 10),
    ],
    'generate_thumbnails_enabled' => env('LOUIS_MEDIA_GENERATE_THUMBNAILS_ENABLED', true),
];
