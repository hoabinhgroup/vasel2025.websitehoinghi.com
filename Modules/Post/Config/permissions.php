<?php

return [
    [
        'name' => 'Posts',
        'flag' => 'post.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'post.create',
        'parent_flag' => 'post.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'post.edit',
        'parent_flag' => 'post.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'post.restore',
        'parent_flag' => 'post.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'post.delete',
        'parent_flag' => 'post.index',
    ],
    [
        'name' => 'Post Categories',
        'flag' => 'categories.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'categories.create',
        'parent_flag' => 'categories.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'categories.edit',
        'parent_flag' => 'categories.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'categories.restore',
        'parent_flag' => 'categories.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'categories.delete',
        'parent_flag' => 'categories.index',
    ],
    [
        'name' => 'Post Tag',
        'flag' => 'tag.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'tag.create',
        'parent_flag' => 'tag.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'tag.edit',
        'parent_flag' => 'tag.index',
    ],
    [
        'name' => 'Restore',
        'flag' => 'tag.restore',
        'parent_flag' => 'tag.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'tag.delete',
        'parent_flag' => 'tag.index',
    ],
    [
        'name' => 'All Tags',
        'flag' => 'tag.getAllTags',
        'parent_flag' => 'tag.index',
    ]
    
    
];