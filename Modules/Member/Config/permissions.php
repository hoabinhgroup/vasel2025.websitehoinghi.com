<?php

return [
    [
        'name' => 'Members',
        'flag' => 'member.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'member.create',
        'parent_flag' => 'member.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'member.edit',
        'parent_flag' => 'member.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'member.restore',
        'parent_flag' => 'member.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'member.delete',
        'parent_flag' => 'member.index',
    ],
    [
        'name' => 'Delete Many',
        'flag' => 'member.deletes',
        'parent_flag' => 'member.index',
    ]
];
