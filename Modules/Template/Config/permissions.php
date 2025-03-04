<?php

return [
    [
        'name' => 'Template',
        'flag' => 'template.index',
    ],
    [
        'name' => 'Save Template',
        'flag' => 'template.create',
        'parent_flag' => 'template.index',
    ],
    [
        'name' => 'Edit Template',
        'flag' => 'template.edit',
        'parent_flag' => 'template.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'template.delete',
        'parent_flag' => 'template.index',
    ],
    [
        'name' => 'Config Template',
        'flag' => 'template.config_widget',
        'parent_flag' => 'template.index',
    ]
    
    
];
