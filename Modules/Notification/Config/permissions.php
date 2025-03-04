<?php

return [
    [
        'name' => 'Notifications',
        'flag' => 'notification.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'notification.create',
        'parent_flag' => 'notification.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'notification.edit',
        'parent_flag' => 'notification.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'notification.restore',
        'parent_flag' => 'notification.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'notification.delete',
        'parent_flag' => 'notification.index',
    ]
];