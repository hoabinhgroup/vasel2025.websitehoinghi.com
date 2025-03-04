<?php

return [
    [
        'name' => 'Blocks',
        'flag' => 'block.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'block.create',
        'parent_flag' => 'block.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'block.edit',
        'parent_flag' => 'block.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'block.restore',
        'parent_flag' => 'block.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'block.delete',
        'parent_flag' => 'block.index',
    ]
];
