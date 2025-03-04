<?php

return [
    [
        'name' => 'Media',
        'flag' => 'media.index',
    ],
    [
        'name'        => 'List media',
        'flag'        => 'media.list',
        'parent_flag' => 'media.index',
    ],
    [
        'name'        => 'File',
        'flag'        => 'files.index',
        'parent_flag' => 'media.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'files.create',
        'parent_flag' => 'files.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'files.edit',
        'parent_flag' => 'files.index',
    ],
    [
        'name'        => 'Trash',
        'flag'        => 'files.trash',
        'parent_flag' => 'files.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'files.destroy',
        'parent_flag' => 'files.index',
    ],
    [
        'name'        => 'Upload',
        'flag'        => 'media.files.upload',
        'parent_flag' => 'files.index',
    ],
    [
        'name'        => 'Upload From Editor',
        'flag'        => 'media.files.upload.from.editor',
        'parent_flag' => 'files.index',
    ],
    [
        'name'        => 'Global Actions',
        'flag'        => 'media.global_actions',
        'parent_flag' => 'files.index',
    ], 
    [
        'name'        => 'Download',
        'flag'        => 'media.download',
        'parent_flag' => 'files.index',
    ],
    [
        'name'        => 'Breadcrumbs',
        'flag'        => 'media.breadcrumbs',
        'parent_flag' => 'files.index',
    ], 
    [
        'name'        => 'Popups',
        'flag'        => 'media.popup',
        'parent_flag' => 'files.index',
    ],   
    
    [
        'name'        => 'Folder',
        'flag'        => 'folders.index',
        'parent_flag' => 'media.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'media.folders.create',
        'parent_flag' => 'folders.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'folders.edit',
        'parent_flag' => 'folders.index',
    ],
    [
        'name'        => 'Trash',
        'flag'        => 'folders.trash',
        'parent_flag' => 'folders.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'folders.destroy',
        'parent_flag' => 'folders.index',
    ],
];