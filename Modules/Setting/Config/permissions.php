<?php

return [
    [
        "name" => "Cài đặt",
        "flag" => "setting.general",
    ],
    [
        "name" => "Cấu hình bộ nhớ đệm",
        "flag" => "setting.cache",
        "parent_flag" => "setting.general",
    ],
    [
        "name" => "Cấu hình email",
        "flag" => "setting.email",
        "parent_flag" => "setting.general",
    ],
    [
        "name" => "Cấu hình Media",
        "flag" => "setting.media",
        "parent_flag" => "setting.general",
    ],
    [
        "name" => "Luu cấu hình Media",
        "flag" => "setting.media.edit",
        "parent_flag" => "setting.general",
    ],
    [
        "name" => "Quản lý Backup",
        "flag" => "setting.backup",
        "parent_flag" => "setting.general",
    ],
    [
        "name" => "Backup Delete",
        "flag" => "backup.delete",
        "parent_flag" => "setting.general",
    ],
    [
        "name" => "Edit Setting",
        "flag" => "setting.edit",
        "parent_flag" => "setting.general",
    ],
    [
        "name" => "Backup Download",
        "flag" => "backup.download",
        "parent_flag" => "setting.general",
    ],
    [
        "name" => "Backup Generation",
        "flag" => "backup.generation",
        "parent_flag" => "setting.general",
    ],
];
