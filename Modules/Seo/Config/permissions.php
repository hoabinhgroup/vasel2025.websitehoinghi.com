<?php

return [
    [
        'name' => 'Seos',
        'flag' => 'seo.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'seo.create',
        'parent_flag' => 'seo.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'seo.edit',
        'parent_flag' => 'seo.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'seo.restore',
        'parent_flag' => 'seo.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'seo.delete',
        'parent_flag' => 'seo.index',
    ]
];
