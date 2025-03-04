<?php

return [
    [
        'name' => 'Paypals',
        'flag' => 'paypal.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'paypal.create',
        'parent_flag' => 'paypal.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'paypal.edit',
        'parent_flag' => 'paypal.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'paypal.restore',
        'parent_flag' => 'paypal.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'paypal.delete',
        'parent_flag' => 'paypal.index',
    ],
    [
        'name' => 'Delete Many',
        'flag' => 'paypal.deletes',
        'parent_flag' => 'paypal.index',
    ]
];
