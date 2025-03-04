<?php

return [
    [
        'name' => 'Apis',
        'flag' => 'api.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'api.create',
        'parent_flag' => 'api.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'api.edit',
        'parent_flag' => 'api.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'api.restore',
        'parent_flag' => 'api.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'api.delete',
        'parent_flag' => 'api.index',
    ],
    [
        'name' => 'Delete Many',
        'flag' => 'api.deletes',
        'parent_flag' => 'api.index',
    ]
];
